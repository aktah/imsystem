

$( "#addStorageForm" ).submit(function( event ) {
    event.preventDefault();

    var name = $("input[name=storage_name]").val();
    var att = $("select[name=storage_attendant] option:selected").val();

    $.ajax({
        url: "../storage/add",
        type: "post",
        dataType: "json",
        data: 'storage_name=' + name + '&',
            success: function (response) {

                if (response.type == 'danger') {
                    var alertTag = $('.alert');
                    if (alertTag.hasClass('d-none')) {
                        alertTag.removeClass('d-none');
                    }
                    alertTag.text('');
                    alertTag.addClass('alert-' + response.type);
                    alertTag.text(response.message);
                    return;
                }

                $('#addStorage').modal('hide');

                if (!alertTag.hasClass('d-none')) {
                    alertTag.text('');
                    alertTag.addClass('d-none');
                    if (alertTag.hasClass('alert-danger')) {
                        alertTag.removeClass('alert-danger');
                    }
                }
                
            },
            error: function (err) {
                console.log(err);
            }
    });
});

$( "#storagePick" ).change(function() {
    if ($(this).val() == -1) {
        $('#addStorage').modal('show');
        if (!$('.alert').hasClass('d-none')) {
            $('.alert').addClass('d-none');
        }
        $(this).val(0);
    }
});


// Drop Image
var dropZone = document.querySelector('.mmn-dropzone');
if (dropZone !== null) {
    dropZone.addEventListener('drop', function(event) {
        event.preventDefault();
        this.classList.remove('mmn-drop');
        startUpload(event.dataTransfer.files[0]);
    }, false);
    
    dropZone.addEventListener('dragover', function(event) {
        event.preventDefault();
        this.classList.add('mmn-drop');
    }, false);
    
    dropZone.addEventListener('dragleave', function(event) {
        event.preventDefault();
        this.classList.remove('mmn-drop');
    }, false);
}

// Image Upload
$("img#uploadImage").click(function() {
    $("input[id='uploadImage']").click();
});

var formdata = new FormData(),
    mimeTypes = [ 'image/jpeg', 'image/png', ],
    progressBar = document.querySelector('.mmn-progress-bar'),
    xhr = new XMLHttpRequest();

if (progressBar !== null) {

    document.querySelector("input[id='uploadImage']").addEventListener('change', function( event ) {
        event.preventDefault();
        startUpload(this.files[0]);
    });

    var startUpload = function(file) {

        let url = $('#uploadUrl').val() ? $('#uploadUrl').val() : "uploadimage" ;

        if (url == undefined)
            return;

        formdata.append('token', $('#token').val());
        formdata.append('uploadImage', file, file.name);

        xhr.upload.addEventListener('progress', function(event) {
            var percentComplete = Math.ceil(event.loaded / event.total * 100);
            progressBar.style.width = percentComplete + '%';
            progressBar.textContent = percentComplete + '%';
        });
    
        xhr.onload = function() {
            if (xhr.status === 200) {
                data = JSON.parse(xhr.responseText);
                if (data.error) {

                    progressBar.style.width = '0%';
                    progressBar.textContent = '0%';

                    Swal.fire({
                    icon: 'error',
                    title: 'การอัพโหลด',
                    text: data.error
                    })
                }

                if (data.upload_data) {
                    $("img#uploadImage").attr("src", data.baseurl + "assets/uploads" + data.path + "/" + data.upload_data.file_name);
                }
                
            }
        }
    
        xhr.open('POST', url);
        xhr.send(formdata);
    }
}

async function srcToFile(src, fileName, mimeType){
    return (await fetch(src)
        .then(function(res){return res.arrayBuffer();})
        .then(function(buf){return new File([buf], fileName, {type:mimeType});})
    );
}

// Drop Multiple Image
if (progressBar !== null) {

    var dropZone = document.querySelector('.mmn-dropzones');
    if (dropZone !== null) {
        dropZone.addEventListener('drop', function(event) {
            event.preventDefault();
            this.classList.remove('mmn-drop');
            startUploads(event.dataTransfer.files);
        }, false);
        
        dropZone.addEventListener('dragover', function(event) {
            event.preventDefault();
            this.classList.add('mmn-drop');
        }, false);
        
        dropZone.addEventListener('dragleave', function(event) {
            event.preventDefault();
            this.classList.remove('mmn-drop');
        }, false);
    }

    var startUploads = async function(files) {
        
        let url = $('#uploadUrl').val() ? $('#uploadUrl').val() : "uploadimage" ;

        if (url == undefined)
            return;

        if (files.length > 20) {
            Swal.fire({
                icon: 'error',
                title: 'การอัพโหลด',
                text: 'จำนวนไฟล์รูปภาพมีเยอะเกินไป กำหนดไว้สูงสุดที่ 20 ไฟล์เท่านั้น'
            })
        }

        formdata = new FormData();
        xhr = new XMLHttpRequest();

        var x = document.querySelectorAll(".mmn-thumbnail img");
        var i;
        for (i = 0; i < x.length; i++) {
            if (x[i].id) {
  
                // รอ gen ไฟล์รูปก่อนส่ง request
                await srcToFile(x[i].src, x[i].id, 'image/png')
                .then(function(file){
                    formdata.append('uploadImage[]', file);
                    console.log(0, file);
                })
                .catch(console.error)
                ;
            }
        }

        formdata.append('token', $('#token').val());

        for (var i = 0; i < files.length; i++) {
            if (mimeTypes.indexOf(files.item(i).type) != -1) {
                formdata.append('uploadImage[]', files.item(i));
                console.log(1, files.item(i));
            }
        }
    
        xhr.upload.addEventListener('progress', function(event) {
            var percentComplete = Math.ceil(event.loaded / event.total * 100);
            progressBar.style.width = percentComplete + '%';
            progressBar.textContent = percentComplete + '%';
        });
    
        xhr.onload = function() {
            if (xhr.status === 200) {

                data = JSON.parse(xhr.responseText);

                for (var x = 0; x < data.length; x++) {

                    if (data[x].error) {

                        progressBar.style.width = '0%';
                        progressBar.textContent = '0%';

                        Swal.fire({
                        icon: 'error',
                        title: 'การอัพโหลด',
                        text: data.error
                        })
                    }

                    if (data[x].upload_data) {
                        setImage(data[x].baseurl, data[x].path, data[x].upload_data.file_name);
                    }
                }
            }
        }
    
        xhr.open('POST', url);
        xhr.send(formdata);
    }
}

var cancelUpload = function(e) {
    var unloadImageName = e.target.getAttribute('data-id');
    
    if (!unloadImageName) 
        return;

    let url = $('#unloadUrl').val() ? $('#unloadUrl').val() : "unloadimage" ;
    let xhr = new XMLHttpRequest();
    let fd = new FormData();

    if (url == undefined)
        return;

    fd.append('image_name', unloadImageName);
 
    xhr.onload = function() {
        if (xhr.status === 200) {

            data = JSON.parse(xhr.responseText);

            if (data.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'ยกเลิกการอัพโหลดรูปภาพ',
                    text: data.error
                })
                return;
            }

            // ลบ temp image ออก
            var values = formdata.getAll("uploadImage[]");
            var index = unloadImageName.split("_");
            values.splice(index[0], 1);
            
            formdata.set("uploadImage[]", values);

            e.target.remove();
        }
    }
 
    xhr.open('POST', url);
    xhr.send(fd);
}

var setImage = function(baseurl, path, filename) {

    if (document.getElementById(filename)) {
        document.getElementById(filename).src = baseurl + "assets/uploads" + path + "/" + filename;
        return;
    }
    clone = document.importNode(document.getElementById('mmn-thumbnail'), true);
 
    var image = clone.querySelector('img');

    image.id = filename;
 
    image.src = baseurl + "assets/uploads" + path + "/" + filename;

    image.nextElementSibling.textContent = filename;

    clone.setAttribute("data-id", filename);
    clone.style.display = "block";

    clone.addEventListener('click', cancelUpload, false);

    document.getElementById('mmn-image-template').appendChild(clone);
}


$(document).ready(function(){
    $('.close-modal').on('click', function(){ 
         $('.modal').modal('hide');
    });
});

$(document).on('click', '[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox();
});
