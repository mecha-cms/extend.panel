(function(win, doc, _) {
    function onChange() {
        var tabs = doc.querySelectorAll('.lot\\:tab'),
            replaceState = 'replaceState' in win.history,
            setAction = function($) {
                var href = $.href;
                while ($ && $.nodeName.toLowerCase() !== 'form') {
                    $ = $.parentNode;
                }
                $ && $.nodeName.toLowerCase() === 'form' && ($.action = href);
            };
        if (tabs.length) {
            tabs.forEach(function($) {
                var panes = [].slice.call($.children),
                    buttons = panes.shift().querySelectorAll('a');
                function onClick(e) {
                    if (!this.parentNode.classList.contains('has:link')) {
                        if (!this.classList.contains('not:active')) {
                            buttons.forEach(function($$$) {
                                $$$.parentNode.classList.remove('is:active');
                                panes[$$$._index] && panes[$$$._index].classList.remove('is:active');
                            });
                            this.parentNode.classList.add('is:active');
                            panes[this._index] && panes[this._index].classList.add('is:active');
                            replaceState && win.history.replaceState({}, "", this.href);
                            setAction(this);
                        }
                        e.preventDefault();
                    }
                }
                buttons.forEach(function($$, i) {
                    $$._index = i;
                    $$.addEventListener("click", onClick, false);
                });
            });
        }
    } onChange();
    _.on('change', onChange);
})(window, document, _);
