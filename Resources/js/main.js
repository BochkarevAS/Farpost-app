window.onload = function () {

    function log(html) {
        document.getElementById('log').innerHTML = html;
    }

    document.forms.upload.onsubmit = function() {
        var file = this.elements.img.files[0];

        if (file) {
            upload(file);
        }
        return false;
    };

    function upload(file) {

        var xhr = new XMLHttpRequest();
        var formData = new FormData();
        formData.append("file", file);

        xhr.upload.onprogress = function(event) {
            log(event.loaded + ' / ' + event.total);
        };

        xhr.onload = xhr.onerror = function() {

            if (this.status == 200) {
                var data = JSON.parse(xhr.responseText);
                var ul = document.getElementById('image');
                var li = document.createElement('LI');
                var a = document.createElement('A');
                a.href = 'show/' + data['id'];
                a.textContent = data['img'];

                li.appendChild(a);
                ul.appendChild(li);

                log("success");
            } else {
                log("error " + this.status);
            }
        };

        xhr.open("POST", "user/img", true);
        xhr.send(formData);
    }
};