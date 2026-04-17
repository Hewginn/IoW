<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.toggle-control').change(function() {
            let control = $(this).is(':checked') == true ? 1 : 0;
            let node_id = $(this).data('id');

            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/changeControl',
                data: {
                    'control': control,
                    'node_id': node_id
                },
                success: function(data){
                    console.log(data.success)
                }
            });
        });
    });
</script>
