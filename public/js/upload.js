let fileList = [];

// Adicionar arquivos à lista ao selecionar
function handleFileSelect(event) {
    const files = event.target.files;
    for (const file of files) {
        fileList.push(file);
    }
    renderFileList();
}

// Renderizar a lista de arquivos selecionados
function renderFileList() {
    const fileDisplay = document.getElementById('file-list');
    fileDisplay.innerHTML = '';

    fileList.forEach((file, index) => {
        const fileItem = document.createElement('div');
        fileItem.className = 'flex justify-between items-center p-2 border border-gray-300 rounded mb-2';
        fileItem.innerHTML = `
            <span class="truncate">${file.name} (${Math.round(file.size / 1024)} KB)</span>
            <button type="button" class="bg-red-500 text-white px-2 py-1 rounded text-sm hover:bg-red-700"
                onclick="removeFile(${index})">Remover</button>
        `;
        fileDisplay.appendChild(fileItem);
    });

    if (fileList.length === 0) {
        const noFilesMessage = document.createElement('p');
        noFilesMessage.className = 'text-gray-500 text-sm text-center';
        noFilesMessage.textContent = 'Nenhum arquivo selecionado.';
        fileDisplay.appendChild(noFilesMessage);
    }
}

// Remover arquivo da lista
function removeFile(index) {
    fileList.splice(index, 1);
    renderFileList();
}