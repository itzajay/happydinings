jQuery(function($){
    $("#tf-above-editor-insert-area").delegate("#add-foodmenu-button", "click", function(e) {
        e.preventDefault();
        $("#add-foodmenu-button").addClass("hidden");
        $("#menu-menu-id-wrap").removeClass("hidden");
    });
    
    $("#menu-menu-id").change(function(){
        var body_container = $(this).closest('#post-body').find('#content_ifr').contents().find('body#tinymce');
        var val = $("#menu-menu-id").val();
        window.glob.execCommand('mceInsertContent', false, "[foodmenu id='"+val+"']");
        //body_container.append("[foodmenu id='"+val+"']");
    });
    
});