//***************************************************************************
//
//***************************************************************************
App = Ember.Application.create({
  LOG_TRANSITIONS: true
});


//***************************************************************************
// Routes
//***************************************************************************
App.Router.map(function() {
  this.route('about');
  this.route('contact');

  this.resource('items', {path: '/items'}, function(){
      this.resource('item', {path: ':item_id'});
  });
});

App.ItemsRoute = Ember.Route.extend({
    model: function(){
        return this.store.find('item');
    }
});

App.ItemRoute = Ember.Route.extend({
    model: function(params){
        return this.store.find('item', params.item_id);
    }
});

//***************************************************************************
// Controllers
//***************************************************************************
App.ItemsController = Ember.ArrayController.extend({
    actions: {
        addItem: function() {
            var name = this.get('newItem');

            if ( !name || !name.trim() ) {
                 return;
            }

            var item = this.store.createRecord('item', {name: name});

            this.set('newItem', '');

            item.save();
        }
    },

    itemCount: function(){
        return this.get('length');
    }.property('@each')

});

App.ItemController = Ember.ObjectController.extend({
    isEditing: false,

    actions: {

        cancelEdit: function() {
            this.set('isEditing', false);
        },

        editItem: function() {
            this.set('isEditing', true);
        },

        saveItem: function() {
            var item = this.get('model');

            item.save();

            this.set('isEditing', false);
        },

        removeItem: function() {
            var item = this.get('model');

            item.destroyRecord();

            this.set('isEditing', false);

            this.transitionToRoute('items');
        }
    }

});

//***************************************************************************
// Models
//***************************************************************************
App.Item = DS.Model.extend({
    name: DS.attr( 'string' ),
    added: DS.attr( 'date' )
});

//***************************************************************************
// Helpers
//***************************************************************************
Ember.Handlebars.helper('format-date', function(date, format){
  //return moment(date).format(format);
  return moment(date).fromNow();
});

