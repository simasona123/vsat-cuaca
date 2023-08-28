<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    @vite(['resources/js/app.js'])

    <script>
        function geoFindMe(submit){
            function success(position){
                const lat = position.coords.latitude;
                const long = position.coords.longitude;
                submit.disabled = false;
                submit.innerHTML = 'Submit';
                document.querySelector('#lat').value = lat;
                document.querySelector('#lon').value = long;
                console.log(lat, long);
            }

            function error(){
                submit.disabled = true;
                alert('Permisi Lokasi belum ada');
            }

            if(!navigator.geolocation){
                alert('Geo tidak support')
            } else {
                submit.disabled = true;
                submit.innerHTML = 'Locating....';
                navigator.geolocation.getCurrentPosition(success, error);

            }
        }

        function closePopup(){
            document.querySelector('#alert').style.display = 'none';
        }
    </script>

</head>

<body class="antialiased">
    <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        @if (session('status'))
            <div id='alert' role="alert" class="rounded-xl border border-gray-100 bg-white p-4 shadow-xl absolute right-4">
                <div class="flex items-start gap-4">
                    <span class="text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
        
                    <div class="flex-1">
                        <strong class="block font-medium text-gray-900"> Data berhasil disimpan</strong>
        
                        <p class="mt-1 text-sm text-gray-700">
                        Terima kasih banyak atas bantuannya 🙏
                        </p>
                    </div>
        
                    <button onclick="closePopup()" class="text-gray-500 transition hover:text-gray-600">
                        <span class="sr-only">Dismiss popup</span>
        
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif
        <div class="flex flex-col items-center justify-center">
            <div class="text-center sm:text-left">
                <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl text-center">
                    Info Cuaca Realtime
                </h1>
                <p class="mt-1.5 text-sm text-center text-gray-500">
                    Stasiun Metorologi Mopah | Stasiun Meteorologi Alor 🌤️
                </p>
            </div>
            <div class="cuaca flex flex-col sm:flex-row justify-around mt-8 gap-4 w-full">
                <a href="#" class="flex flex-col justify-center items-center">
                    <h3 class="mb-2 text-center text-gray-900">
                        Stasiun Meteorologi Mopah
                    </h3>

                    <h3 class="mt-2 text-md text-center text-gray-900">
                        {{ $merauke->Time }} WIB
                    </h3>

                    <img alt="Art" src="{{$cuaca[$merauke->weather] . '-' . $am_pm[0] . '.png'}}"
                        class="object-cover w-16" />

                    <h3 class="mt-2 text-md text-center font-bold text-gray-900">
                        {{ $merauke->weather }}
                    </h3>

                </a>
                <a href="#" class="flex flex-col justify-center items-center">
                    <h3 class="mb-2 text-center text-gray-900">
                        Stasiun Meteorologi Alor
                    </h3>

                    <h3 class="mt-2 text-md text-center text-gray-900">
                        {{ $alor->Time }} WIB
                    </h3>

                    <img alt="Art" src="{{$cuaca[$alor->weather] . '-' . $am_pm[1] . '.png'}}"
                        class="object-cover w-16" />

                    <h3 class="mt-2 text-md text-center font-bold text-gray-900">
                        {{ $alor->weather }}
                    </h3>

                </a>
            </div>
            <h1 class="mt-5 text-xl font-bold text-gray-900 text-center mb-2">
                Pelaporan yang Berhasil Diinput
            </h1>
            <div class="flex flex-row justify-around w-full">
                <div class="overflow-x-auto w-[40%] mt-3">
                    <h1 class="font-bold text-gray-900 text-center mb-2">
                        Stasiun Meteorologi Alor
                    </h1>
                    <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                    <thead class="ltr:text-left rtl:text-right">
                        <tr>
                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                            No
                        </th>
                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                            Waktu (UTC)
                        </th>
                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                            Feedback
                        </th>
                        </tr>
                    </thead>
                    
                    @php
                        $i=1;
                    @endphp
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($alor_feedbacks as $item)
                            <tr>
                                <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                                    {{$i}}
                                </td>
                                <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{$item->created_at}}</td>
                                <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{$item->feedback}}</td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                    </tbody>
                    </table>
                </div>
                <div class="overflow-x-auto w-[40%] mt-3">
                    <h1 class="font-bold text-gray-900 text-center mb-2">
                        Stasiun Meteorologi Mopah
                    </h1>
                    <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                    <thead class="ltr:text-left rtl:text-right">
                        <tr>
                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                            No
                        </th>
                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                            Waktu (UTC)
                        </th>
                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                            Feedback
                        </th>
                        </tr>
                    </thead>
                    
                    @php
                        $j=1;
                    @endphp
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($merauke_feedbacks as $item)
                            <tr>
                                <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                                    {{$j}}
                                </td>
                                <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{$item->created_at}}</td>
                                <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{$item->feedback}}</td>
                            </tr>
                            @php
                                $j++;
                            @endphp
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
            <a
                class="mt-4 inline-block rounded bg-indigo-600 px-8 py-3 text-sm font-medium text-white transition hover:rotate-2 hover:scale-110 focus:outline-none focus:ring active:bg-indigo-500"
                href="/pelaporan"
            >
                Laporkan
            </a>
        </div>
    </div>
    <script>
        // geoFindMe(document.querySelector('#submit-button'));
    </script>
</body>

</html>
