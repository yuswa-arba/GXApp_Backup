import {get, post} from '../helpers/api'
$(document).ready(function () {

    let form = {}
    $('#submitBtn').on('click', function () {
        form.name = $('#employeeName').val();
        console.log("form:" + JSON.stringify(form))
        console.log("formData: " + JSON.stringify(new FormData()))
        console.log(objectToFormData(form))

        post('/testing/upload', objectToFormData(form))
            .then((res) => {
                console.log(res)
                alert('Success! ' + res.data.message)
                window.location.href = '/testing/upload'
            })
    })


    $('#employeePhoto').on('change', function (e) {
        console.log(e.target.files[0]);
        let file = e.target.files[0];

        form.employeePhoto = file;

        setPreview(file)

    })

    function setPreview(file) {
        if (file instanceof File) {
            const fileReader = new FileReader()
            fileReader.onload = (event) => {
                $('#img-preview').prop('src', event.target.result);
            }
            fileReader.readAsDataURL(file)
        } else if (file === 'string') {
            $('#img-preview').prop('src', '/images/' + file)
        } else {
            $('#img-preview').prop('src', '')
        }
    }


    function objectToFormData(obj, form, namespace) {
        let fd = form || new FormData()
        let formKey
        for (var property in obj) {
            if (obj.hasOwnProperty(property)) {
                if (namespace) {
                    formKey = namespace + '[' + property + ']';
                } else {
                    formKey = property;
                }
                if (obj[property] instanceof Array) {
                    for (var i = 0; i < obj[property].length; i++) {
                        objectToFormData(obj[property][i], fd, `${property}[${i}]`);
                    }
                } else if (typeof obj[property] === 'object' && !(obj[property] instanceof File)) {
                    objectToFormData(obj[property], fd, property);
                } else {
                    fd.append(formKey, obj[property]);
                }
            }
        }
        return fd
    }


})