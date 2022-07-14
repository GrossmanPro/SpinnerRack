$(document).ready( function () {
    $("#adminCreatorsTable").DataTable();
    
    $(".deleteCreator").click(function() {
        var deleteConfirm = confirm("Do you want to delete this creator?");
        if (deleteConfirm) {
            var creatorId = this.id.split("_");
            $("#deleteId").val(creatorId[1]);
            $("#creatorDelete").submit();
        }
    });
    
});
