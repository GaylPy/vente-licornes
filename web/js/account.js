function changeAccount(ref) {

    if ($('#update'+ref).attr('hidden')) {
        $('#update'+ref).removeAttr('hidden');
        $('#save'+ref).attr('hidden', 'hidden');
        $('#form'+ref+' :input').each(function(){
            var input = $(this);
            input.attr('readonly', 'readonly');
        });

        if(ref == 'Account') {
            $('#newPassword').val('XXXXXXXXXXXXXXX');
            $('#fgLastPwd').attr('hidden', 'hidden');
            $('#fgCheckPwd').attr('hidden', 'hidden');
        }
    } else {
        $('#update'+ref).attr('hidden', 'hidden');
        $('#save'+ref).removeAttr('hidden');
        $('#form'+ref+' :input').each(function(){
            var input = $(this);
            input.removeAttr('readonly', 'readonly');
        });

        if(ref == 'Account') {
            $('#newPassword').val('');
            $('#fgLastPwd').removeAttr('hidden');
            $('#fgCheckPwd').removeAttr('hidden');
        }
    }
};