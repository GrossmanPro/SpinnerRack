$(document).ready(function(){
    $("#submitComic").click(function() {
        $("#comicInput").submit();
    });    
    
    var artistCount = 0;
    $("#artists").change(function(){
        artistCount++;
        // remove comma to resolve security issue w/encoding
        var artistName = $("#artists :selected").text().split(', ');
        var artistId = $("#artists :selected").val();
        
        if (artistId === "0") {
            return;
        } 
        
        var html = '<div class="input-group" id="artistDiv_' + encodeURIComponent(artistCount) + '">';
        html += '<input type="text" class="form-control-plaintext" value="' + encodeURIComponent(artistName[1]) + ' ' + encodeURIComponent(artistName[0]) + '" readonly>';
        html += '<input type="button" class="btn btn-danger btn-sm removeCreator" value="Delete">';
        html += '<input type="hidden" id="artist_' + encodeURIComponent(artistCount) + '" name="artist_' + encodeURIComponent(artistCount) + '" value="' + encodeURIComponent(artistId) + '">';
        html += '<div>';
        $("#artistList").append(html);
    });
    
    var scripterCount = 0;
    $("#scripters").change(function(){
        scripterCount++;
        var scripterName = $("#scripters :selected").text().split(', ');
        var scripterId = $("#scripters :selected").val();
        
        if (scripterId === "0") {
            return;
        }
        
        var html = '<div class="input-group" id="scripterDiv_' + encodeURIComponent(scripterCount) + '">';
        html += '<input type="text" class="form-control-plaintext" value="' + encodeURIComponent(scripterName[1]) + ' ' + encodeURIComponent(scripterName[0]) + '" readonly>';
        html += '<input type="button" class="btn btn-danger btn-sm removeCreator" value="Delete">';
        html += '<input type="hidden" id="scripter_' + encodeURIComponent(scripterCount) + '" name="scripter_' + encodeURIComponent(scripterCount) + '" value="' + encodeURIComponent(scripterId) + '">';
        html += '<div>';
        $("#scripterList").append(html);
    });  
    
    $("body").on("click", ".removeCreator", function(){
        $(this).closest("div").remove();
    });
});