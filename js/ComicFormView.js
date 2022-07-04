$(document).ready(function(){
    $("#submitComic").click(function() {
        $("#comicInput").submit();
    });    
    
    var artistCount = 0;
    $("#artists").change(function(){
        artistCount++;
        var artistName = $("#artists :selected").text();
        var artistId = $("#artists :selected").val();
        
        if (artistId === "0") {
            return;
        } 
        
        var html = '<div class="input-group" id="artistDiv_' + artistCount + '">';
        html += '<input type="text" class="form-control-plaintext" value="' + artistName + '" readonly>';
        html += '<input type="button" class="btn btn-danger removeCreator" value="Delete">';
        html += '<input type="hidden" id="artist_' + artistCount + '" name="artist_' + artistCount + '" value="' + artistId + '">';
        html += '<div>';
        $("#artistList").append(html);
    });
    
    var scripterCount = 0;
    $("#scripters").change(function(){
        scripterCount++;
        var scripterName = $("#scripters :selected").text();
        var scripterId = $("#scripters :selected").val();
        
        if (scripterId === "0") {
            return;
        }
        
        var html = '<div class="input-group" id="scripterDiv_' + scripterCount + '">';
        html += '<input type="text" class="form-control-plaintext" value="' + scripterName + '" readonly>';
        html += '<input type="button" class="btn btn-danger removeCreator" value="Delete">';
        html += '<input type="hidden" id="scripter_' + scripterCount + '" name="scripter_' + scripterCount + '" value="' + scripterId + '">';
        html += '<div>';
        $("#scripterList").append(html);
    });  
    
    $("body").on("click", ".removeCreator", function(){
        $(this).closest("div").remove();
    });
});