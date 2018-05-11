/**
 * Created by kevinpurwono on 16/11/17.
 */
// export function toMulipartedForm(form, mode) {
//     if(mode === 'edit' && typeof form.image === 'string') {
//         const temp = JSON.parse(JSON.stringify(form))
//         delete temp.image
//         return temp
//     } else {
//         return objectToFormData(form)
//     }
// }

export function objectToFormData(obj, form, namespace) {
    let fd = form || new FormData()
    let formKey
    for (let property in obj) {
        if (obj.hasOwnProperty(property)) {
            if (namespace) {
                formKey = namespace + '[' + property + ']';
            } else {
                formKey = property;
            }
            if (obj[property] instanceof Array) {
                for (let i = 0; i < obj[property].length; i++) {
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


export function makeBlob(dataURL) {
    let BASE64_MARKER = ';base64,';
    if (dataURL.indexOf(BASE64_MARKER) == -1) {
        let parts = dataURL.split(',');
        let contentType = parts[0].split(':')[1];
        let raw = decodeURIComponent(parts[1]);
        return new Blob([raw], {type: contentType});
    }
    let parts = dataURL.split(BASE64_MARKER);
    let contentType = parts[0].split(':')[1];
    let raw = window.atob(parts[1]);
    let rawLength = raw.length;

    let uInt8Array = new Uint8Array(rawLength);

    for (let i = 0; i < rawLength; ++i) {
        uInt8Array[i] = raw.charCodeAt(i);
    }

    return new Blob([uInt8Array], {type: contentType});


}
