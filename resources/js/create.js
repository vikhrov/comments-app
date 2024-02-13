jQuery(document).ready(function() {
    function previewText() {
        var text = $('#text').val();
        $('#previewText').text(text);
    }

    function previewImage() {
        var input = document.getElementById('media');
        var previewImage = document.getElementById('previewImage');
        var file = input.files[0];

        if (file) {
            $("#previewImage").show();
            var reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            console.log($("#previewImage"));
            $("#previewImage").hide();
        }
        return true;
    }

    function showPreview() {
        previewText();
        previewImage();
        $('#exampleModal').show();
    }

    function closePreview() {
        $('#exampleModal').hide();
    }

    function insertTag(openTag, closeTag) {
        var textarea = document.getElementById('text');
        var start = textarea.selectionStart;
        var end = textarea.selectionEnd;
        var selectedText = textarea.value.substring(start, end);
        var replacement = '<' + openTag + '>' + selectedText + (closeTag ? '</' + closeTag + '>' : '');

        textarea.value = textarea.value.substring(0, start) + replacement + textarea.value.substring(end);

        previewText();
    }

    function insertLink() {
        var url = prompt("Enter the URL:");
        var textarea = document.getElementById('text');
        var start = textarea.selectionStart;
        var end = textarea.selectionEnd;
        if (url !== null) {
            var selectedText = textarea.value.substring(start, end);
            var link = '<a href="' + url + '">' + selectedText + '</a>';
            console.log(link);

            textarea.value = textarea.value.substring(0, start) + link + textarea.value.substring(end);

            previewText();
        }
    }

    function previewText() {
        var text = $('#text').val();
        $('#previewText').html(text);
    }

    // Сделаем функции доступными в глобальной области видимости
    window.previewText = previewText;
    window.previewImage = previewImage;
    window.showPreview = showPreview;
    window.closePreview = closePreview;
    window.insertTag = insertTag;
    window.insertLink = insertLink;
});
