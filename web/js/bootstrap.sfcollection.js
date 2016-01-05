/* ==========================================================
 * bc-bootstrap-collection.js
 * http://bootstrap.braincrafted.com
 * ==========================================================
 * Copyright 2013 Florian Eckerstorfer
 *
 * ========================================================== */


!function ($) {

    "use strict"; // jshint ;_;

    /* COLLECTION CLASS DEFINITION
     * ====================== */

    var addField = '[data-addfield="collection"]',
        removeField = '[data-removefield="collection"]',
        CollectionAdd = function (el) {
            $(el).on('click', addField, this.addField);
        },
        CollectionRemove = function (el) {
            $(el).on('click', removeField, this.removeField);
        }
    ;

    CollectionAdd.prototype.addField = function (e) {
        var $this = $(this),
            selector = $this.attr('data-collection'),
            prototypeName = $this.attr('data-prototype-name')
        ;

        e && e.preventDefault();

        var collection = $('#'+selector),
            list = collection.find('> ul'),
            count = list.find('li').size()
        ;

        var newWidget = collection.attr('data-prototype');

        // Check if an element with this ID already exists.
        // If it does, increase the count by one and try again
        var newName = newWidget.match(/id="(.*?)"/);
        var re = new RegExp(prototypeName, "g");
        while ($('#' + newName[1].replace(re, count)).size() > 0) {
            count++;
        }
        newWidget = newWidget.replace(re, count);
        newWidget = newWidget.replace(/__id__/g, newName[1].replace(re, count));
        var newLi = $('<li></li>').html(newWidget);
        newLi.appendTo(list);
        
        var parentid = newName[1].replace(re, count);
        
        $('#'+parentid+' textarea.wysiwyg').each(function() {
            var options = {
                script_url : '/bundles/itechcareresources/js/tinymce/tinymce.min.js',
                theme: "modern",
                plugins: [ "advlist autolink lists link image charmap print preview hr anchor pagebreak", "searchreplace wordcount visualblocks visualchars code fullscreen", "insertdatetime media nonbreaking save table contextmenu directionality", "emoticons template paste textcolor" ],
                toolbar: "insertfile undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor"
            };
            $this = $(this);
            if($this.is('[required]')) {
                options.oninit = function(editor) {
                    editor.on('change', function(e) {
                        editor.save();
                    });
                }
            }
            $this.tinymce(options);
        });
        
        $('#'+parentid+' :file.file').each(function() {
            $this = $(this);
            $this.fileinput({'showUpload':false, 'showPreview': false, browseClass: "btn btn-success", browseLabel: " Image", browseIcon: '<span class="glyphicon glyphicon-picture"></span>', removeClass: "btn btn-danger", removeLabel: "Delete", removeIcon: '<span class="glyphicon glyphicon-trash"></span>'});
        });
        
        $('#'+parentid+' select.chosen').each(function() {
            $this = $(this);
            $this.chosen({width: "100%", disable_search_threshold: 10});
        });
    };

    CollectionRemove.prototype.removeField = function (e) {
        var $this = $(this),
            selector = $this.attr('data-field')
        ;

        e && e.preventDefault();

        var listElement = $this.closest('li').remove();
    }


    /* COLLECTION PLUGIN DEFINITION
     * ======================= */

    var oldAdd = $.fn.addField;
    var oldRemove = $.fn.removeField;

    $.fn.addField = function (option) {
        return this.each(function () {
            var $this = $(this),
                data = $this.data('addfield')
            ;
            if (!data) {
                $this.data('addfield', (data = new CollectionAdd(this)));
            }
            if (typeof option == 'string') {
                data[option].call($this);
            }
        });
    };

    $.fn.removeField = function (option) {
        return this.each(function() {
            var $this = $(this),
                data = $this.data('removefield')
            ;
            if (!data) {
                $this.data('removefield', (data = new CollectionRemove(this)));
            }
            if (typeof option == 'string') {
                data[option].call($this);
            }
        });
    };

    $.fn.addField.Constructor = CollectionAdd;
    $.fn.removeField.Constructor = CollectionRemove;


    /* COLLECTION NO CONFLICT
     * ================= */

    $.fn.addField.noConflict = function () {
        $.fn.addField = oldAdd;
        return this;
    }
    $.fn.removeField.noConflict = function () {
        $.fn.removeField = oldRemove;
        return this;
    }
    
    var origAppend = $.fn.append;

    $.fn.append = function (e) {
    	//e && e.preventDefault();
        return origAppend.apply(this, arguments).trigger("append");
    };


    /* COLLECTION DATA-API
     * ============== */

    $(document).on('click.addfield.data-api', addField, CollectionAdd.prototype.addField);
    $(document).on('click.removefield.data-api', removeField, CollectionRemove.prototype.removeField);

 }(window.jQuery);