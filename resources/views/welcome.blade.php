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
        <div class="flex flex-col items-center justify-center">
            <div class="text-center sm:text-left">
                <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl text-center">
                    Pelaporan Cuaca
                </h1>
                <p class="mt-1.5 text-sm text-center text-gray-500">
                    Stasiun Metorologi Mopah | Stasiun Meteorologi Alor 🌤️
                </p>
            </div>
            <form class="flex flex-col items-center" action="" method="POST">
                @csrf
                <div class="flex flex-col sm:flex-row mt-5">
                    <div class="flex flex-row mt-2 items-center">
                        <div class="w-72">
                            <select class="rounded-md border-gray-200 shadow-sm sm:text-sm p-3 pe-5 w-full"
                                name="stasun">
                                <option selected value="{{ $nama }}">{{ $stasiun }}</option>
                            </select>
                        </div>
                        <svg class="relative right-9" xmlns="http://www.w3.org/2000/svg" height="1em"
                            viewBox="0 0 576 512">
                            <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z" />
                        </svg>
                    </div>
                    <div class="flex flex-row mt-2 items-center">
                        <div class="w-72">
                            <select class="rounded-md border-gray-200 shadow-sm sm:text-sm p-3 pe-5 w-full"
                                name="cuaca">
                                <option value="Cerah">Cerah</option>
                                <option value="Hujan Ringan Sedang">Hujan Ringan - Sedang</option>
                                <option value="Hujan Lebat">Hujan Lebat</option>
                            </select>
                        </div>
                        <svg class="relative right-9" xmlns="http://www.w3.org/2000/svg" height="1em"
                            viewBox="0 0 640 512">
                            <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M0 336c0 79.5 64.5 144 144 144H512c70.7 0 128-57.3 128-128c0-61.9-44-113.6-102.4-125.4c4.1-10.7 6.4-22.4 6.4-34.6c0-53-43-96-96-96c-19.7 0-38.1 6-53.3 16.2C367 64.2 315.3 32 256 32C167.6 32 96 103.6 96 192c0 2.7 .1 5.4 .2 8.1C40.2 219.8 0 273.2 0 336z" />
                        </svg>
                    </div>
                </div>
                <button type="submit" id="submit-button"
                    class="w-fit mt-3 inline-flex items-center gap-2 rounded border border-indigo-600 bg-indigo-600 px-4 py-3 text-white 
                        hover:bg-transparent hover:text-indigo-600 focus:outline-none focus:ring active:text-indigo-500">
                    <span class="text-sm font-sm">Laporkan</span>

                    <svg class="h-5 w-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </button>
            </form>
            <div class="cuaca flex flex-col sm:flex-row justify-around mt-8 gap-4 w-full">
                <a href="#" class="flex flex-col justify-center items-center">
                    <h3 class="mb-2 text-center text-gray-900">
                        Stasiun Meteorologi Mopah
                    </h3>

                    <h3 class="mt-2 text-md text-center text-gray-900">
                        {{ $merauke->Time }}
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
                        {{ $alor->Time }}
                    </h3>

                    <img alt="Art" src="{{$cuaca[$alor->weather] . '-' . $am_pm[1] . '.png'}}"
                        class="object-cover w-16" />

                    <h3 class="mt-2 text-md text-center font-bold text-gray-900">
                        {{ $alor->weather }}
                    </h3>

                </a>
            </div>
            {{-- <div class="overflow-x-auto mt-3">
                <h1 class="text-xl font-bold text-gray-900 text-center mb-2">
                    Pelaporan yang Berhasil Diinput
                </h1>
                <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                <thead class="ltr:text-left rtl:text-right">
                    <tr>
                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                        No
                    </th>
                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                        Waktu
                    </th>
                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                        Lokasi
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
                    @foreach ($feedbacks as $item)
                        <tr>
                            <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                                {{$i}}
                            </td>
                            <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{$item->Time}}</td>
                            <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{$item->location}}</td>
                            <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{$item->feedback_weather}}</td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                </tbody>
                </table>
            </div> --}}
        </div>
    </div>
    <script>
        // geoFindMe(document.querySelector('#submit-button'));
    </script>
</body>

</html>
