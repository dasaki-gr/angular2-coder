
System.config({
  packages: {
    [(baseUrl + '/apps/app01')]: {
      format: 'register',
      defaultExtension: 'js'
    }
	}
});
console.error.bind(console, 'Message on Console !!! (System Start)');
System.import( baseUrl + '/apps/app01/boot')
      .then(null, console.error.bind(console));
