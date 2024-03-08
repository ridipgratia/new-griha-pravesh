import BlockModule from "./BlockModule.js";
const block_module_obj = new BlockModule();
$(document).ready(function () {
    $(document).on('click', '#excel_browse', function () {
        $('#excel_file').click();
    });
    $(document).on('change', '#excel_file', function () {
        if (this.files.length != 0) {
            $('#excel_file_name').html(this.files[0].name);
            console.log(this.files);
            $('#excel_file_success').html('<i class="fa-solid fa-circle-check"></i>')
        } else {
            $('#excel_file_name').html("No File Selected");
            $('#excel_file_success').html('<i class="fa-regular fa-circle-xmark"></i>')
        }
    });
    $(document).on('submit', '#main-excel-upload-form-id', async function (e) {
        e.preventDefault();
        await block_module_obj.uploadExcelBlock($(this), $('#upload_excel_btn'));
    });
});