@extends('layouts.master') {{-- Extends the master layout --}}

@section('title', 'Uploader') {{-- Sets the title section of the page --}}

@section('content') {{-- Begins the content section of the page --}}
    <label id="upload-zone" for="upload"
        class="overflow-hidden cursor-pointer block relative w-full py-[1rem] px-[0.5rem] border-2 rounded-md border-dashed border-white border-opacity-40 duration-300 ease-in-out hover:border-violet-400 upload-zone">
        {{-- Label element for upload zone --}}
        <header class="flex flex-col justify-center items-center gap-[0.5rem]">
            {{-- Header section containing upload zone content --}}
            <img src="{{ asset('assest/Upload.gif') }}" alt="uploading" class="w-[220px] m-auto" />
            {{-- Image for uploading animation --}}
            <p class="drag block text-slate-100 text-[1.2rem] text-center">
                Select your file or <span class="text-violet-400"> drop </span> it here
            </p>
            {{-- Text informing user to select or drop file --}}
            <h2 class="drop hidden font-bold text-slate-100 text-[2rem] text-center">
                Drop the desired file here <span class="text-violet-400"> drop </span>
            </h2>
            {{-- Placeholder for dropping file --}}
            <form action="{{ route('upload') }}" method="post" id="upload-form" enctype="multipart/form-data">
                {{-- Form for file upload --}}
                @csrf {{-- CSRF token for form security --}}
                <input type="file" name="file" id="upload" hidden /> {{-- File input field --}}
            </form>
            @error('file')
                {{-- Error handling for file upload --}}
                <div class="text-red-800">{{ $message }}</div> {{-- Display error message --}}
            @enderror
        </header>
    </label>

    @foreach ($links as $link)
        {{-- Loop through links --}}
        @php
            $url = explode('/', $link->private_url); // Extract URL parts for download link
        @endphp
        <div class="progress-area m-auto p-3 w-full max-w-[960px] flex flex-col">
            {{-- Container for progress area --}}
            <div class="progress-block mb-[2rem]">
                {{-- Progress block --}}
                <header class="flex justify-between items-center file-header mb-[0.5rem] hide show">
                    {{-- Header for file info --}}
                    <button
                        class="copy-link-btn flex justify-center items-center relative cursor-pointer border border-white border-opacity-70 rounded-lg p-2 duration-200 ease-in-out text-slate-50 text-[1.3rem] hover:bg-violet-600 hover:text-white"
                        onclick="copyMessage('{{ route('download', $url) }}')">
                        {{-- Button to copy download link --}}
                        <ion-icon name="documents-outline" role="img" class="md hydrated"></ion-icon>
                        {{-- Icon for document --}}
                    </button>
                    <h2 class="text-right text-slate-300">{{ $link->file_name }}... : <span class="text-slate-50">نام
                            فایل</span>
                    </h2>
                    {{-- Display file name --}}
                </header>
            </div>
        </div>
    @endforeach

@endsection
