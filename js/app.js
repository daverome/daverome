
App = Ember.Application.create({
  LOG_TRANSITIONS: true
});



//***************************************************************************
// Routes
//***************************************************************************
App.Router.map(function() {
  // put your routes here
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

App.IndexRoute = Ember.Route.extend({
  model: function() {
    return ['red', 'yellow', 'blue'];
  }
});

//***************************************************************************
// Controllers
//***************************************************************************


//***************************************************************************
// Models
//***************************************************************************
App.Item = DS.Model.extend({
    name: DS.attr('string')
});