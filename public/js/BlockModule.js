class BlockModule {
    constructor() {

    }
    async uploadExcelBlock(form, btn) {
        try {
            let form_data = new FormData(form[0]);
            await $.ajax({
                type: "post",
                url: "/upload-excel-post",
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                data: form_data,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (result) {
                    if (result.status == 200) {
                        Swal.fire(
                            'Success',
                            result.message,
                            'info'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        var message = '';
                        result.message.forEach(element => {
                            message += element + '<br>';
                        });
                        Swal.fire(
                            'info',
                            message,
                            'info'
                        );
                    }
                }, error: function (data) {
                    console.log(data);
                }
            });
        } catch (error) {
            Swal.fire(
                'info',
                're-select your excel file'
            );
        }
    }
}
export default BlockModule;