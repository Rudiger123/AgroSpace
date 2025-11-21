<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - AgroSpace</title>
    
   @vite('resources/css/app.css')
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'agro-green': '#2E7D32',
                        'agro-beige': '#F5F5DC',
                        'agro-gray': '#37474F',
                        'agro-yellow': '#FFB300',
                        'primary': {
                            500: '#1B5E20', // Base
                            600: '#15803d', // Darker for hover
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'], // Assure-toi d'avoir une police propre
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-pattern {
            background-color: #F5F5DC;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%232e7d32' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="bg-pattern min-h-screen flex items-center justify-center p-4 text-[#37474F]">

    <div class="max-w-2xl w-full bg-white rounded-2xl shadow-xl overflow-hidden relative">
        <!-- Top Decorative Bar -->
        <div class="h-2 bg-[#1B5E20] w-full"></div>

        <div class="p-8 md:p-12 flex flex-col items-center text-center">
            <!-- Logo AgroSpace (Placeholder Icon) -->
            <div class="mb-6">
                <svg class="w-16 h-16 text-[#1B5E20]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>

            <!-- Error Code Display -->
            <h1 class="text-6xl md:text-8xl font-bold text-[#2E7D32] tracking-tighter mb-2">
                @yield('code')
            </h1>

            <!-- Title -->
            <h2 class="text-2xl md:text-3xl font-bold text-[#37474F] mb-4">
                @yield('message')
            </h2>

            <!-- Description -->
            <p class="text-lg text-gray-600 mb-8 max-w-md mx-auto leading-relaxed">
                @yield('description')
            </p>

            <!-- Illustration Specific to Error -->
            <div class="mb-8 opacity-90">
                @yield('image')
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ url('/') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-[#1B5E20] hover:bg-[#15803d] transition-colors duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Retour aux champs
                </a>
                
                @yield('actions')
            </div>
        </div>
        
        <!-- Bottom Leaf Decor -->
        <div class="absolute bottom-0 right-0 opacity-10 pointer-events-none">
            <svg width="150" height="150" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#2E7D32" d="M45,-76.3C58.9,-69.3,71.4,-59.1,81.6,-46.7C91.8,-34.3,99.7,-19.7,98.3,-5.6C96.9,8.5,86.2,22.1,75.3,34.2C64.4,46.3,53.3,56.9,40.9,64.4C28.5,71.9,14.8,76.3,0.6,75.3C-13.6,74.3,-28.2,67.9,-41.7,60.1C-55.2,52.3,-67.6,43.1,-76.2,31.1C-84.8,19.1,-89.6,4.3,-87.6,-9.4C-85.6,-23.1,-76.8,-35.7,-65.9,-45.3C-55,-54.9,-42,-61.5,-29.4,-69.2C-16.8,-76.9,-4.6,-85.7,4.2,-92.3L13,-98.9L45,-76.3Z" transform="translate(100 100)" />
            </svg>
        </div>
    </div>

</body>
</html>