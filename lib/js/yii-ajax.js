(function () {
	var YiiAjax = {

		_eventHandlers : {},

		on : function (event, handler, scope) {
			if (!this._eventHandlers[event]) {
				this._eventHandlers[event] = [];
			}
			this._eventHandlers[event].push({
				event : event,
				handler : handler,
				scope : scope || this
			});
			return this;
		},

		trigger : function () {
			var event = arguments.shift();
			if (this._eventHandlers[event]) {
				for (var i in this._eventHandlers[event]) {
					this._eventHandlers[event][i].handler.apply(this._eventHandlers[event][i].scope, arguments);
				}
			}
		},

		actions : {
			callback : function () {
				var name = arguments.shift();
				if (window[name] && typeof window[name] == 'function') {
					window[name].apply(window, arguments);
				}
			},

			'jquery.replace' : function (selector, html) {
				$(selector).replaceWith(html);
			},

			'jquery.html' : function (selector, html) {
				$(selector).html(html);
			}
		},

		parse : function (response) {
			if (response['actions']) {
				this.trigger('before:apply', response);
				for (var i in response.actions) {
					this.trigger('before:' + response.actions[i].id, response.actions[i].attributes);
					if (!this.actions[i][response.actions[i].id]) {
						this.trigger.call(this, 'action:' + response.actions[i].id, response.actions[i].attributes);
					} else {
						this.actions[i][response.actions[i].id].apply(this, response.actions[i].attributes);
					}
					this.trigger('after:' + response.actions[i].id, response.actions[i].attributes);
				}
				this.trigger('after:apply', response);
			}
		}
	};

	window.YiiAjax = YiiAjax;
})();