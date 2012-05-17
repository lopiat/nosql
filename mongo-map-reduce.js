map1 = function() {
	if(this.plec == "K")
		emit(this.imie,1);
};

map2 = function() {
	if(this.plec == "M")
	emit(this.imie,1);
};

map3 = function() {
	if(parseInt(this.lsylab) == 4)
		emit(this.imie,1);
};

map4 = function() {
	if(this.imie.indexOf("o") > 0)
		emit(this.imie, 1);
};

map5 = function() {
	emit(this.imie,parseInt(this.lsylab));
};


reduce1 = function(key, values) {
	var suma = 0;
	for(i=0;i<values.length;i++) 
		suma+=values[i];
	return suma;
};

reduce2 = function(key, values) {
	var suma = 0;
	for(i=0;i<values.length;i++) 
		suma+=values[i];
	return suma/values.length;
};

res = db.imionka.mapReduce(map1, reduce1,{out: { inline : 1}});
printjson(res);
