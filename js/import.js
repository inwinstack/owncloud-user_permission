/**
 * ownCloud - user_permission
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Dino Peng <dino.p.inwinstack.com>
 * @copyright Dino Peng 2015
 */


(function($,OC){

    function createImportButton() {
        var button = $('<button class="import" id="import">' + t('user_permission','import') + '</button>');
        
        return button;
    }

    $(function () {

        ajaxSuccess.bind('GET:/settings/users/users', function(event) {
            if(!$('#import').length){
                var button = createImportButton();
                button.appendTo($('#controls'));
                var input = $('<input type="file" class="upload" name="fileToUpload" id="upload" style="display:none"/>');
                input.appendTo($('#controls'));
            }
        });
       
        $('#app-content').on('click', '#import', function() {
            $('#upload').trigger('click')
            $('#upload').fileupload({
            url: OC.generateUrl('/apps/user_permission/importUser'),
            add: function(e, data) {
                data.submit();
            },
            done:function(e, data) {
                $('#everyonegroup').click();
                
                response = data.response();

                $li = GroupList.getGroupLI(UserList.currentGid);
                userCount = GroupList.getUserCount($li);
                GroupList.setUserCount($li, userCount + response.result.data.length);
            },
            }); 
        });

    });
})(jQuery, OC);
