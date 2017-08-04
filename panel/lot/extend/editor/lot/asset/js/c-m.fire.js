(function($, win, doc) {

    var forms = $.forms,
        i, j, k = forms.$;

    function apply_CodeMirror(node) {
        var size = [$(node).outerWidth(), $(node).outerHeight()],
            editor = CodeMirror.fromTextArea(node, typeof $.CM === "object" ? $.CM : {
                lineNumbers: true,
                lineWrapping: true
            });
        var type = $(node).data('type'),
            def = 'application/x-httpd-php',
            aliases = {
                'html': def,
                'markdown': {
                    'name': 'text/x-markdown',
                    'fencedCodeBlocks': true
                },
                'xml': def
            };
        editor.addKeyMap({
            'Ctrl-J': 'toMatchingTag',
            'Ctrl-Space': function(cm) {
                return cm.showHint && cm.showHint({hint: CodeMirror.hint.anyword});
            },
            'F11': function(cm) {
                cm.setOption('fullScreen', !cm.getOption('fullScreen'));
            }
        });
        if (type) {
            type = type.toLowerCase();
            editor.setOption('mode', aliases[type] || type);
            if (type === 'markdown') {
                editor.addKeyMap({
                    'Enter': 'newlineAndIndentContinueMarkdownList'
                });
            }
        }
        editor.setSize(size[0], size[1]);
        $(win).on("resize", function() {
            $(editor.display.wrapper).width(0).width($(node).parent().width());
        });
        return editor;
    }

    forms.editor = {};

    for (i in k) {
        forms.editor[i] = {};
        for (j in k[i]) {
            if (/(^|\s)(editor|CodeMirror|CM)(\s|$)/.test(k[i][j].className)) {
                forms.editor[i][j] = apply_CodeMirror(k[i][j]);
            }
        }
    }

    forms.CM = forms.editor;

})(window.PANEL, window, document);