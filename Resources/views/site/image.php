

<form name="upload">
    <input type="file" name="img">
    <input type="submit" name="submit" value="Загрузить">
</form>

<div id="log">Прогресс загрузки</div>

<script>

    function log(html) {
        document.getElementById('log').innerHTML = html;
    }

    document.forms.upload.onsubmit = function() {
        var file = this.elements.img.files[0];

        console.log(file);

        if (file) {
            upload(file);
        }
        return false;
    };

    function upload(file) {

        var xhr = new XMLHttpRequest();

        // обработчик для закачки
        xhr.upload.onprogress = function(event) {
            log(event.loaded + ' / ' + event.total);
        };

        // обработчики успеха и ошибки
        // если status == 200, то это успех, иначе ошибка
        xhr.onload = xhr.onerror = function() {
            if (this.status == 200) {
                log("success");
            } else {
                log("error " + this.status);
            }
        };

        xhr.open("POST", "image/image", true);
        xhr.send(file);

    }

</script>
