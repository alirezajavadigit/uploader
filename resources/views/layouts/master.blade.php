<!doctype html>
<html lang="fa">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <title>@yield('title')</title>
    <!--  -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!--  -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assest/icon.webp') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <!--  -->
    <link rel="stylesheet" href="{{ asset('ss/css/index.css') }}" />
    <!--  -->
</head>

<body class="bg-[#121212]">
    <noscript>
        <strong>please enable javascript to run this app</strong>
    </noscript>
    <!--  -->
    <div id="app" class="min-h-[100vh] flex flex-col justify-end items-end">
        <div class="m-auto p-3 w-full max-w-[960px]">
            
            <!--  -->
            <h1
                class="text-slate-50 font-bold text-[3rem] text-right mb-[1rem] flex justify-center items-center gap-[1rem] max-[480px]:text-[2rem]">
                <p class="flex justify-center items-center"><ion-icon name="cloud-upload-outline"></ion-icon></p>
                <span
                    class="inline-block w-full h-[2px] bg-violet-400 opacity-30 flex-1 rounded-md max-[480px]:hidden"></span>
                <p>Uploader</p>
            </h1>
            <!--  -->
            @yield('content')
        </div>
        <!--  -->
        <div class="progress-area m-auto p-3 w-full max-w-[960px] flex flex-col"></div>
    </div>
    <!--  -->
    <script src="{{ asset('ss/script/app.js') }}"></script>
</body>

</html>
