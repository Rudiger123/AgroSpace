<?php

namespace App\Livewire\Admin\OffersManagement;

use App\Models\Category;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Gestion des Offres')]
class ModerateOffers extends Component
{
    use WithPagination;

    // États des Modales
    public $showDetailsModal = false;
    public $showValidateModal = false;
    public $showRejectModal = false;
    public $showDeleteModal = false;

    // Données
    public $selectedOffer = null;
    public $offerId = null;
    public $validationNote = '';
    public $rejectionReason = '';
    public $deletionReason = '';

    // Filtres
    public $search = '';
    public $statusFilter = 'pending';
    public $categorieFilter = '';
    public $regionFilter = '';
    public $verifiedFilter = 'all';
    public $sortBy = 'latest';
    public $dateFrom = '';
    public $dateTo = '';

    protected $queryString = ['search', 'statusFilter', 'categorieFilter', 'verifiedFilter'];

    protected $regions = [
        'Adamaoua', 'Centre', 'Est', 'Extrême-Nord',
        'Littoral', 'Nord', 'Nord-Ouest', 'Ouest',
        'Sud', 'Sud-Ouest'
    ];

    public function mount()
    {
        $this->dateFrom = now()->subMonth()->format('Y-m-d');
        $this->dateTo = now()->format('Y-m-d');
    }

    // --- GESTION DES MODALES ---

    public function resetModals()
    {
        $this->showDetailsModal = false;
        $this->showValidateModal = false;
        $this->showRejectModal = false;
        $this->showDeleteModal = false;
        $this->validationNote = '';
        $this->rejectionReason = '';
        $this->deletionReason = '';
    }

    public function viewDetails($id)
    {
        $this->selectedOffer = Offer::with(['producer', 'photos', 'avis.user', 'category'])->findOrFail($id);
        $this->resetModals();
        $this->showDetailsModal = true;
    }

    public function openValidateModal($id)
    {
        $this->offerId = $id;
        $this->resetModals();
        $this->showValidateModal = true;
    }

    public function openRejectModal($id)
    {
        $this->offerId = $id;
        $this->resetModals();
        $this->showRejectModal = true;
    }

    public function confirmDelete($id)
    {
        $this->offerId = $id;
        $this->resetModals();
        $this->showDeleteModal = true;
    }

    // --- ACTIONS MÉTIER ---

    public function validateOffer()
    {
        try {
            DB::beginTransaction();
            $offer = Offer::with('producer')->findOrFail($this->offerId);

            $offer->update([
                'statut' => 'validé',
                'date_validation' => now(),
                'validated_by' => Auth::id(),
                'validation_note' => $this->validationNote,
            ]);

            // Notification email améliorée
            if ($offer->producer && $offer->producer->email) {
                $emailContent = view('emails.offer-validated', [
                    'producerName' => $offer->producer->name,
                    'offerTitle' => $offer->titre,
                    'validationNote' => $this->validationNote,
                    'offerUrl' => route('offers-management', $offer->id)
                ])->render();

                Mail::send([], [], function ($message) use ($offer, $emailContent) {
                    $message->to($offer->producer->email)
                        ->subject('✅ Votre offre a été validée - ' . config('app.name'))
                        ->html($emailContent);
                });
            }

            DB::commit();
            $this->resetModals();
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => '✅ Offre validée avec succès et producteur notifié par email.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Erreur : ' . $e->getMessage()]);
        }
    }

    public function rejectOffer()
    {
        $this->validate(['rejectionReason' => 'required|string|min:10|max:500']);

        try {
            DB::beginTransaction();
            $offer = Offer::with('producer')->findOrFail($this->offerId);

            $offer->update([
                'statut' => 'rejeté',
                'date_rejection' => now(),
                'rejected_by' => Auth::id(),
                'rejection_reason' => $this->rejectionReason,
            ]);

            // Notification email de rejet
            if ($offer->producer && $offer->producer->email) {
                $emailContent = view('emails.offer-rejected', [
                    'producerName' => $offer->producer->name,
                    'offerTitle' => $offer->titre,
                    'rejectionReason' => $this->rejectionReason,
                    'supportUrl' => route('contact')
                ])->render();

                Mail::send([], [], function ($message) use ($offer, $emailContent) {
                    $message->to($offer->producer->email)
                        ->subject('❌ Votre offre a été rejetée - ' . config('app.name'))
                        ->html($emailContent);
                });
            }

            DB::commit();
            $this->resetModals();
            $this->dispatch('toast', [
                'type' => 'warning',
                'message' => '⚠️ Offre rejetée et producteur notifié par email.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Erreur : ' . $e->getMessage()]);
        }
    }

    public function updateStatus($id, $status)
    {
        try {
            $offer = Offer::with('producer')->findOrFail($id);
            $offer->update(['statut' => $status]);

            // Notification de suspension d'offre
            if ($status === 'suspendue' && $offer->producer && $offer->producer->email) {
                $emailContent = view('emails.offer-suspended', [
                    'producerName' => $offer->producer->name,
                    'offerTitle' => $offer->titre,
                    'supportUrl' => route('contact')
                ])->render();

                Mail::send([], [], function ($message) use ($offer, $emailContent) {
                    $message->to($offer->producer->email)
                        ->subject('🚫 Suspension de votre offre - ' . config('app.name'))
                        ->html($emailContent);
                });

                $this->dispatch('toast', [
                    'type' => 'warning',
                    'message' => '🚫 Offre suspendue et producteur notifié par email.'
                ]);
            } else {
                $this->dispatch('toast', ['type' => 'success', 'message' => "✅ Statut mis à jour : $status"]);
            }
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Erreur de mise à jour.']);
        }
    }

    public function deleteOffer()
    {
        $this->validate(['deletionReason' => 'required|string|min:5']);

        try {
            $offer = Offer::with(['producer', 'photos'])->findOrFail($this->offerId);
            $producerEmail = $offer->producer->email ?? null;
            $producerName = $offer->producer->name ?? 'Producteur';
            $offerTitle = $offer->titre;

            foreach ($offer->photos as $photo) {
                $photo->delete();
            }

            $offer->delete();

            // Notification email de suppression avec raison
            if ($producerEmail) {
                $emailContent = view('emails.offer-deleted', [
                    'producerName' => $producerName,
                    'offerTitle' => $offerTitle,
                    'deletionReason' => $this->deletionReason,
                    'supportUrl' => route('contact')
                ])->render();

                Mail::send([], [], function ($message) use ($producerEmail, $emailContent) {
                    $message->to($producerEmail)
                        ->subject('🗑️ Suppression de votre offre - ' . config('app.name'))
                        ->html($emailContent);
                });
            }

            $this->resetModals();
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => '🗑️ Offre supprimée définitivement et producteur notifié par email.'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Erreur : ' . $e->getMessage()]);
        }
    }

    public function suspendProducer($producerId)
    {
        try {
            $producer = User::findOrFail($producerId);

            $producer->update(['is_active' => false]);

            $suspendedCount = Offer::where('producer_id', $producerId)
                ->where('statut', '!=', 'suspendue')
                ->update(['statut' => 'suspendue']);

            // Notification email de suspension de compte
            if ($producer->email) {
                $emailContent = view('emails.producer-suspended', [
                    'producerName' => $producer->name,
                    'suspendedOffersCount' => $suspendedCount,
                    'supportUrl' => route('contact')
                ])->render();

                Mail::send([], [], function ($message) use ($producer, $emailContent) {
                    $message->to($producer->email)
                        ->subject('🚫 Suspension de votre compte - ' . config('app.name'))
                        ->html($emailContent);
                });
            }

            $this->dispatch('toast', [
                'type' => 'warning',
                'message' => "🚫 Producteur {$producer->name} suspendu. {$suspendedCount} offre(s) désactivée(s). Email de notification envoyé."
            ]);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Erreur lors de la suspension : ' . $e->getMessage()]);
        }
    }

    public function toggleFeatured($id)
    {
        $offer = Offer::find($id);
        if ($offer) {
            $offer->update(['is_featured' => !$offer->is_featured]);
            $message = $offer->is_featured ? '⭐ Offre mise en avant' : 'Offre retirée de la mise en avant';
            $this->dispatch('toast', ['type' => 'success', 'message' => $message]);
        }
    }

    public function bulkValidate()
    {
        try {
            $offersToValidate = Offer::with('producer')
                ->where('statut', 'en attente')
                ->when($this->categorieFilter, fn ($q) => $q->where('category_id', $this->categorieFilter))
                ->get();

            $count = 0;
            foreach ($offersToValidate as $offer) {
                $offer->update([
                    'statut' => 'validé',
                    'date_validation' => now(),
                    'validated_by' => Auth::id(),
                ]);

                // Envoi email pour chaque offre validée
                if ($offer->producer && $offer->producer->email) {
                    $emailContent = view('emails.offer-validated', [
                        'producerName' => $offer->producer->name,
                        'offerTitle' => $offer->titre,
                        'validationNote' => 'Validation automatique en masse',
                        'offerUrl' => route('offers-list', ['search' => $offer->titre])
                    ])->render();

                    Mail::send([], [], function ($message) use ($offer, $emailContent) {
                        $message->to($offer->producer->email)
                            ->subject('✅ Votre offre a été validée - ' . config('app.name'))
                            ->html($emailContent);
                    });
                }
                $count++;
            }

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => "✅ {$count} offre(s) validée(s) en masse. Notifications envoyées."
            ]);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Erreur validation en masse : ' . $e->getMessage()]);
        }
    }

    // --- RENDER ---

    public function render()
    {
        $query = Offer::with(['producer', 'photos', 'category']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('titre', 'like', '%' . $this->search . '%')
                  ->orWhereHas('producer', fn ($p) => $p->where('name', 'like', '%' . $this->search . '%'));
            });
        }

        if ($this->statusFilter !== 'all') {
            $this->statusFilter === 'pending' ? $query->where('statut', 'en attente') : $query->where('statut', $this->statusFilter);
        }

        if ($this->categorieFilter) {
            $query->where('category_id', $this->categorieFilter);
        }
        if ($this->regionFilter) {
            $query->where('region', $this->regionFilter);
        }

        if ($this->verifiedFilter !== 'all') {
            $this->verifiedFilter === 'verified' ? $query->where('statut', 'validé') : $query->where('statut', '!=', 'validé');
        }

        switch ($this->sortBy) {
            case 'oldest': $query->oldest('date_publication');
                break;
            case 'price_high': $query->orderByDesc('prix');
                break;
            case 'price_low': $query->orderBy('prix');
                break;
            default: $query->latest('date_publication');
        }

        $offers = $query->paginate(15);

        // --- STATISTIQUES ---

        $statsRaw = Offer::select('statut', DB::raw('count(*) as total'))
            ->groupBy('statut')
            ->pluck('total', 'statut')
            ->toArray();

        $stats = [
            'total' => array_sum($statsRaw),
            'pending' => $statsRaw['en attente'] ?? 0,
            'validated' => $statsRaw['validé'] ?? 0,
            'rejected' => $statsRaw['rejeté'] ?? 0,
            'suspended' => $statsRaw['suspendue'] ?? 0,
            'featured' => Offer::where('is_featured', true)->count(),
            'today' => Offer::whereDate('created_at', today())->count(),
            'thisWeek' => Offer::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'thisMonth' => Offer::whereMonth('created_at', now()->month)->count(),
        ];

        $chartStatusData = [
            'series' => array_values($statsRaw),
            'labels' => array_keys($statsRaw)
        ];

        // Top catégories
        $topCategories = Offer::select('category_id', DB::raw('count(*) as total'))
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->limit(5)
            ->with('category')
            ->get();

        $chartCategoryData = [
            'series' => $topCategories->pluck('total')->toArray(),
            'labels' => $topCategories->map(fn ($item) => $item->category->name ?? 'Inconnu')->toArray()
        ];

        // Évolution des offres (7 derniers jours)
        $evolutionData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $evolutionData['dates'][] = $date->format('d/m');
            $evolutionData['counts'][] = Offer::whereDate('created_at', $date)->count();
        }

        // Top régions
        $topRegions = Offer::select('region', DB::raw('count(*) as total'))
            ->groupBy('region')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $chartRegionData = [
            'series' => $topRegions->pluck('total')->toArray(),
            'labels' => $topRegions->pluck('region')->toArray()
        ];

        $allCategories = Category::where('type', 'offer')->orderBy('name')->get();

        return view('livewire.admin.offers-management.moderate-offers', [
            'offers' => $offers,
            'categories' => $allCategories,
            'regions' => $this->regions,
            'stats' => $stats,
            'chartStatusData' => $chartStatusData,
            'chartCategoryData' => $chartCategoryData,
            'evolutionData' => $evolutionData,
            'chartRegionData' => $chartRegionData,
        ]);
    }
}
