const upload = document.getElementById("upload");
const uploadForm = document.getElementById("upload-form");
const uploadZone = document.getElementById("upload-zone");
const drag = document.querySelector(".drag");
const drop = document.querySelector(".drop");

/**
 * Copies the given text message to the clipboard.
 *
 * @param {string} text The message to be copied to the clipboard.
 */
function copyMessage(text) {
    // Create a temporary textarea element to hold the text.
    const textarea = document.createElement('textarea');
    
    // Set the value of the textarea to the text to be copied.
    textarea.value = text;
    
    // Make sure the textarea is not visible on the screen.
    textarea.style.position = 'fixed';  // Prevent scrolling to the bottom of the page in MS Edge.
    textarea.style.opacity = '0';
    
    // Append the textarea to the document body.
    document.body.appendChild(textarea);
    
    // Select the text in the textarea.
    textarea.select();
    textarea.setSelectionRange(0, 99999);  // For mobile devices
    
    try {
        // Copy the selected text to the clipboard.
        const successful = document.execCommand('copy');
        if (successful) {
            console.log('Text copied to clipboard successfully!');
        } else {
            console.error('Failed to copy text to clipboard.');
        }
    } catch (err) {
        // Log any errors that occur during the copy process.
        console.error('Unable to copy to clipboard', err);
    }
    
}

uploadZone.addEventListener("dragover", (e) => {
	drop.classList.remove("hidden");
	drop.classList.add("block");
	drag.classList.add("hidden");
	drag.classList.remove("block");
	e.preventDefault();
});

uploadZone.addEventListener("drop", (e) => {
	document.getElementById("upload").files = e.dataTransfer.files;
	drop.classList.remove("block");
	drop.classList.add("hidden");
	drag.classList.remove("hidden");
	drag.classList.add("block");
	uploadFileHandler();
	e.preventDefault();
});

function uploadFileHandler() {
	const files = upload.files;

	for (let i = 0; i < files.length; i++) {
		const xhr = new XMLHttpRequest();
		xhr.open("POST", "");

		const formData = (files[i].name, files[i]);
		const progressBlock = addProgressBar(files[i]);

		xhr.upload.addEventListener("progress", (event) => {
			const progressBar = progressBlock.querySelector(".progress-bar div");
			const progressText = progressBlock.querySelector(".progress-bar p");
			const fileHeader = progressBlock.querySelector(".file-header");

			if (event.lengthComputable == true) {
				const percent = ((event.loaded / event.total) * 100).toFixed(1);
				progressBar.style.width = percent + "%";
				progressBar.classList.add("progressing");
				progressText.textContent = percent + "%";
				progressText.classList.add("fade");

				const progressBarWidth = parseInt(progressBar.style.width);

				if (progressBarWidth > 50) {
					progressText.classList.add("text-slate-50");
				}

				if (progressBarWidth == 100) {
					fileHeader.classList.add("show");
					progressText.textContent = "تکمیل شد";
					progressText.classList.remove("fade");
					setTimeout(() => {
						progressText.innerHTML = `<i class="flex justify-center items-center text-[2rem] animate-pulse"><ion-icon name="cloud-done"></ion-icon></i>`;
					}, 1000);
					progressBar.classList.remove("progressing");
					progressBar.classList.add("bg-[#16a34a]");
				}
			}
		});
		uploadForm.submit();
		xhr.send(formData);
	}
}

function addProgressBar(file) {
	const progressArea = document.querySelector(".progress-area");
	const fileName = file.name.slice(0, 15);
	const html = `
    <header class="flex justify-between items-center  file-header mb-[0.5rem] hide">
        <button class="copy-link-btn flex justify-center items-center relative cursor-pointer border border-white border-opacity-70 rounded-lg p-2 duration-200 ease-in-out text-slate-50 text-[1.3rem] hover:bg-violet-600 hover:text-white" onclick="copyFileLink(event)">
        <ion-icon name="documents-outline"></ion-icon>
        </button>
        <h2 class="text-right text-slate-300">${fileName}... : <span class="text-slate-50">نام فایل</span></h2>
    </header>
    <div class="progress-bar w-full h-[34px] overflow-hidden relative rounded-2xl border border-white bg-white">
        <div class="progress-inner bg-transparent h-[34px] duration-200 ease-linear"></div>
        <div class="progress-info flex justify-center items-center gap-[0.5rem] select-none absolute top-[50%] left-[50%]">
            <p class="percent">0</p>
        </div>
    </div>`;

	const block = document.createElement("div");
	block.classList.add("progress-block", "mb-[2rem]");
	block.innerHTML = html;
	const lastUploaded = progressArea.lastElementChild;
	if (lastUploaded) {
		lastUploaded.classList.add("order-1");
	}
	progressArea.appendChild(block);
	return block;
}

upload.addEventListener("change", uploadFileHandler);


