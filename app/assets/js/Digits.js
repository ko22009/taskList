module.exports = function (num) {
	if (num > 999999999999) return 'Слишком большое число';
	else return Convert(num);
};

var words = [['ноль', ['один', 'одна', 'одно'],
	['два', 'две', 'два'], 'три', 'четыре', 'пять',
	'шесть', 'семь', 'восемь', 'девять', 'десять',
	'одиннадцать', 'двенадцать', 'тринадцать',
	'четырнадцать', 'пятнадцать', 'шестнадцать',
	'семнадцать', 'восемнадцать', 'девятнадцать'],
	[,,'двадцать', 'тридцать', 'сорок', 'пятьдесят',
		'шестьдесят', 'семьдесят', 'восемьдесят',
		'девяносто'],
	[,'сто', 'двести', 'триста', 'четыреста', 'пятьсот',
		'шестьсот', 'семьсот', 'восемьсот', 'девятьсот'],
	['тысяча', 'тысячи', 'тысяч'],
	['миллион', 'миллиона', 'миллионов'],
	['миллиард', 'миллиарда', 'миллиардов']];

function Convert(num, aCase, aBool) {
	var p, a;
	a = words[0][num];
	num = parseInt(num, 10);
	if (num < 20) {
		if(aBool && !num) return ' ';
		else if(a instanceof Array) return a[aCase || 0];
		else return a;
	}
	if (num < 100) {
		p = parseInt(num / 10, 10);
		return Join(words[1][p],
			Convert(num % 10, aCase, true));
	}
	if (num < 1000) {
		p = parseInt(num / 100, 10);
		return Join(words[2][p],
			Convert(num % 100, aCase, true));
	}
	if (num < 1000000) {
		p = parseInt(num / 1000, 10);
		return Join(Convert(p, 1, true),
			Proper(p, words[3]),
			Convert(num % 1000, aCase, true));
	}
	if (num < 1000000000) {
		p = parseInt(num / 1000000, 10);
		return Join(Convert(p, 0, true),
			Proper(p, words[4]),
			Convert(num % 1000000, aCase, true));
	}
	p = parseInt(num / 1000000000, 10);
	return Join(Convert(p, 0, true),
		Proper(p, words[5]),
		Convert(num % 1000000000, aCase, true));
}

function Proper(num, aArr) {
	num = Simple(num);
	if(num == 1) return aArr[0];
	else if(num < 5 && num) return aArr[1];
	else return aArr[2];
}

function Simple(num) {
	if(num < 20) return num;
	else if(num < 100) return num % 10;
	else return arguments.callee(num % 100);
}

function Join() {
	return [].join.call(arguments, ' ');
}