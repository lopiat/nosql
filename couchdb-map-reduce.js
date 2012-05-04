var couchapp = require('couchapp');
ddoc = {
    _id: '_design/app'
  , views: {}
}
module.exports = ddoc;

ddoc.views.plec = {
  map: function(doc) {
       emit(doc.plec);
  },
  reduce: "_count"
}

ddoc.views.sylaba = {
  map: function(doc) {
       emit(doc.lsylab);
  },
  reduce: "_count"
}

ddoc.views.dlugoscimienia = {
  map: function(doc) {
       emit(doc.imie, doc.imie.length);
  }, 
  reduce: function(keys,values) {
    return values[0];
  }
}

ddoc.views.sumujSylaby = {
  map: function(doc) {
       emit(doc.imie, parseInt(doc.lsylab));
  }, 
  reduce: function(keys,values) {
    return sum(values);
  }
}
