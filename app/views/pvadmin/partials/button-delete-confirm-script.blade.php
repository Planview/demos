<script>
    $(document).ready(function(){ 
        // submit delete only after user confirms
        $('form.form-button-delete button.btn-danger').click(function() {
            var c = confirm("Please click OK to confirm, because this action cannot be undone.");
            if(c){
                $(this).closest('form.form-button-delete').submit();
            }
        });
    });
</script>
