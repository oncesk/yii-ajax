(function () {

	function Chain() {}

	Chain.prototype.break = false;



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

		trigger : function (event, data, chain) {
			if (this._eventHandlers[event]) {
				for (var i in this._eventHandlers[event]) {
					this._eventHandlers[event][i].handler.call(this._eventHandlers[event][i].scope, data, chain);
				}
			}
		},

		actions : {

			'jquery.replace' : function (attributes) {
				$(attributes.selector).replaceWith(attributes.html);
			},

			'jquery.html' : function (attributes) {
				$(attributes.selector).html(attributes.html);
			}
		},

		parse : function (response) {
			if (response['actions']) {
				var chain = new Chain();
				this.trigger('before:apply', response, chain);
				if (chain.break === true) {
					return;
				}
				for (var i in response.actions) {
					var actionChain = new Chain();
					this.trigger('before:' + response.actions[i].id, response.actions[i].attributes, actionChain);
					if (actionChain.break === true) {
						continue;
					}
					if (!this.actions[response.actions[i].id]) {
						this.trigger.call(this, ':' + response.actions[i].id, response.actions[i].attributes, actionChain);
					} else {
						this.actions[response.actions[i].id].call(this, response.actions[i].attributes, actionChain);
					}
					if (actionChain.break === true) {
						continue;
					}
					this.trigger('after:' + response.actions[i].id, response.actions[i].attributes, actionChain);
				}
				this.trigger('after:apply', response, chain);
			}
		}
	};

	YiiAjax.ajax = function () {
		var xhr;
		var isParsed = false;

		function createProxy(method, xhr) {
			var origin = xhr[method];
			xhr[method] = function () {
				var fn = arguments[0] || function () {};
				origin(function () {
					prepareResponseAndCallFn(fn, arguments, xhr);
				});
			};
		}

		function prepareResponseAndCallFn(fn, args, xhr) {
			if (args[0] && args[0]['YiiAjax']) {
				if (!isParsed) {
					YiiAjax.parse(args[0]);
					isParsed = true;
				}
				fn.call(xhr, args[0].response, args[1], args[2]);
			} else {
				fn.apply(xhr, args);
			}
		}


		if (arguments[0] && typeof arguments[0]['success'] == 'function') {
			var success = arguments[0]['success'];
			arguments[0]['success'] = function () {
				prepareResponseAndCallFn(success, arguments, xhr);
			};
		}

		xhr = $.ajax.apply($, arguments);
		createProxy('done', xhr);
		createProxy('success', xhr);
		return xhr;
	};

	window.YiiAjax = YiiAjax;
})();