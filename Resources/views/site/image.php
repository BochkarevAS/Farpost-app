

<form name="upload">
    <input type="file" name="img">
    <input type="submit" name="submit" value="Загрузить">
</form>

<div id="log">Прогресс загрузки</div>

<ul id="image">
    <?php foreach ($images as $image) : ?>
        <li><?= $image['img'] ?></li>
    <?php endforeach; ?>
</ul>

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
        var formData = new FormData();
        formData.append("file", file);

        xhr.upload.onprogress = function(event) {
            log(event.loaded + ' / ' + event.total);
        };

        xhr.onload = xhr.onerror = function() {
            if (this.status == 200) {

                var ul = document.getElementById('image');
                var li = document.createElement('LI');
                li.textContent = JSON.parse(xhr.responseText).img;
                ul.appendChild(li);

                log("success");
            } else {
                log("error " + this.status);
            }
        };

        xhr.open("POST", "user/img", true);
        xhr.send(formData);
    }

</script>
