(function($, win, doc) {

    var form = $.Form,
        i, j, k = form.lot;

    function apply_CodeMirror(node) {
        var size = [$(node).outerWidth(), $(node).outerHeight()],
            editor = CodeMirror.fromTextArea(node, {
                lineNumbers: true,
                lineWrapping: true,
                mode: 'application/x-httpd-php',
                addModeClass: true,
                matchBrackets: true,
                matchTags: {
                    bothTags: true
                },
                autoCloseTags: {
                    whenClosing: true,
                    whenOpening: true,
                    dontCloseTags: ["area", "base", "br", "col", "command", "embed", "hr", "img", "input", "keygen", "link", "meta", "param",
                       "source", "track", "wbr"],
                    indentTags: ["blockquote", "body", "div", "dl", "fieldset", "form", "frameset", "h1", "h2", "h3", "h4",
                    "h5", "h6", "head", "html", "object", "ol", "select", "table", "tbody", "tfoot", "thead", "tr", "ul"]
                },
                autoCloseBrackets: true
            });
        var type = $(node).data('type'),
            aliases = {
                'html': 'application/x-httpd-php',
                'xml': 'application/x-httpd-php'
            };
        if (type) {
            type = type.toLowerCase();
            editor.setOption('mode', aliases[type] || type);
        }
        editor.addKeyMap({
            'Ctrl-J': 'toMatchingTag',
            'F11': function(cm) {
                cm.setOption('fullScreen', !cm.getOption('fullScreen'));
            }
        });
        var display = node.style.display;
        editor.setSize(size[0], size[1]);
        $(win).on("resize", function() {
            node.style.display = "";
            editor.display.wrapper.style.width = 'auto';
            size = [$(node).outerWidth(), $(node).outerHeight()];
            editor.setSize(size[0], size[1]);
            node.style.display = display;
        });
        return editor;
    }

    form.editor = {};

    for (i in k) {
        for (j in k[i]) {
            if ($(k[i][j]).hasClass('code')) {
                if (!form.editor[i]) {
                    form.editor[i] = {};
                }
                form.editor[i][j] = apply_CodeMirror(k[i][j]);
            }
        }
    }
    
})(Panel, window, document);