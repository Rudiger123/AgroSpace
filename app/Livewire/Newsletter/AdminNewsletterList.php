<?php

namespace App\Livewire\Newsletter;

use App\Models\NewsletterSubscriber;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

#[Layout('layouts.app')]
#[Title("Agrospace Newsletter Dashboard")]
class AdminNewsletterList extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $selectedSubscribers = [];
    public $selectAll = false;
    public $dateRange = '30_days';

    public $stats = [];
    public $chartData = [
        'labels' => [],
        'subscriptions' => [],
        'unsubscriptions' => [],
    ];
    
    public $statusBreakdown = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'filter' => ['except' => 'all'],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'dateRange' => ['except' => '30_days'],
    ];

    public function mount()
    {
        $this->statusBreakdown = [
            'labels' => [__('newsletter.subscribed'), __('newsletter.unsubscribed')],
            'values' => [0, 0],
        ];
        $this->loadStats();
    }

    public function loadStats()
    {
        $startDate = match ($this->dateRange) {
            '7_days' => Carbon::now()->subDays(7),
            '30_days' => Carbon::now()->subDays(30),
            '90_days' => Carbon::now()->subDays(90),
            default => null,
        };

        $totalSubscribers = NewsletterSubscriber::count();
        $activeSubscribers = NewsletterSubscriber::active()->count();
        $unsubscribed = $totalSubscribers - $activeSubscribers;

        $this->stats = [
            'total' => number_format($totalSubscribers, 0, ',', ' '),
            'active' => number_format($activeSubscribers, 0, ',', ' '),
            'unsubscribed' => number_format($unsubscribed, 0, ',', ' '),
            'active_percentage' => $totalSubscribers > 0 ? round(($activeSubscribers / $totalSubscribers) * 100) : 0,
        ];

        $this->statusBreakdown['values'] = [$activeSubscribers, $unsubscribed];

        if (!$startDate) {
            $this->chartData = ['labels' => [], 'subscriptions' => [], 'unsubscriptions' => []];
            $this->dispatch('stats-updated', ['statsData' => ['chartData' => $this->chartData, 'statusBreakdown' => $this->statusBreakdown]]);
            return;
        }

        $dateRangeCollection = collect(Carbon::parse($startDate)->daysUntil(Carbon::now()->addDay()));
        $allDates = $dateRangeCollection->map(fn ($date) => $date->format('Y-m-d'))->toArray();

        $subscriptionsData = NewsletterSubscriber::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $unsubscriptionsData = NewsletterSubscriber::select(
            DB::raw('DATE(updated_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->unsubscribed()
            ->where('updated_at', '>=', $startDate)
            ->whereRaw('DATE(created_at) != DATE(updated_at)')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $chartSubscriptions = [];
        $chartUnsubscriptions = [];

        foreach ($allDates as $date) {
            $chartSubscriptions[] = $subscriptionsData->get($date)['count'] ?? 0;
            $chartUnsubscriptions[] = $unsubscriptionsData->get($date)['count'] ?? 0;
        }

        $this->chartData = [
            'labels' => $allDates,
            'subscriptions' => $chartSubscriptions,
            'unsubscriptions' => $chartUnsubscriptions,
        ];

        $this->dispatch('stats-updated', ['statsData' => [
            'chartData' => $this->chartData,
            'statusBreakdown' => $this->statusBreakdown
        ]]);
    }

    public function updatedDateRange()
    {
        $this->loadStats();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function bulkSendEmail()
    {
        $this->dispatch('openEmailModal');

        $this->dispatch('toast', [
            'type' => 'info',
            'message' => count(NewsletterSubscriber::active()->get()) . " " . __("newsletter.active_subscribers_targeted")
        ]);
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedSubscribers = $this->subscribers->pluck('id')->map(fn ($id) => (string) $id)->toArray();
        } else {
            $this->selectedSubscribers = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'title' => __('newsletter.delete_confirm_title'),
            'text' => __('newsletter.delete_confirm_text'),
            'icon' => 'warning',
            'confirmText' => __('newsletter.delete_confirm_button'),
            'cancelText' => __('newsletter.cancel'),
            'method' => 'deleteSubscriber',
            'params' => [$id]
        ]);
    }

    #[On('deleteSubscriber')]
    public function deleteSubscriber($id)
    {
        NewsletterSubscriber::findOrFail($id)->delete();

        $this->dispatch('toast', [
            'message' => __('newsletter.subscriber_deleted'),
            'type' => 'success',
        ]);
    }

    public function confirmBulkDelete()
    {
        if (empty($this->selectedSubscribers)) {
            $this->dispatch('toast', [
                'message' => __('newsletter.select_at_least_one'),
                'type' => 'warning'
            ]);
            return;
        }

        $subscriberCount = count($this->selectedSubscribers);
        $subscriberText = $subscriberCount > 1
            ? __("newsletter.selected_subscribers_count", ['count' => $subscriberCount])
            : __("newsletter.selected_subscriber");

        $this->dispatch('swal:confirm', [
            'title' => __('newsletter.bulk_delete_title'),
            'text' => __("newsletter.bulk_delete_text", ['subscriber' => $subscriberText]),
            'icon' => 'warning',
            'confirmText' => __('newsletter.delete_confirm_button'),
            'cancelText' => __('newsletter.cancel'),
            'method' => 'bulkDelete',
            'params' => []
        ]);
    }

    #[On('bulkDelete')]
    public function bulkDelete()
    {
        $count = NewsletterSubscriber::whereIn('id', $this->selectedSubscribers)->delete();
        $this->selectedSubscribers = [];
        $this->selectAll = false;

        $this->dispatch('toast', [
            'message' => __("newsletter.bulk_deleted", ['count' => $count]),
            'type' => 'success',
        ]);
    }

    #[Computed]
    public function subscribers()
    {
        $query = NewsletterSubscriber::query();

        if ($this->search) {
            $query->where(fn ($q) => $q->where('name', 'like', "%{$this->search}%")
                                      ->orWhere('email', 'like', "%{$this->search}%"));
        }

        match ($this->filter) {
            'active' => $query->whereNull('unsubscribed_at'),
            'unsubscribed' => $query->whereNotNull('unsubscribed_at'),
            default => $query
        };

        return $query->orderBy($this->sortField, $this->sortDirection)
                    ->paginate(10);
    }

    public function render()
    {
        return view('livewire.newsletter.admin-newsletter-list');
    }
}