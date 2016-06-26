System.config({
  packages: {
    [(baseUrl + '/apps/app02')]: {
      format: 'register',
      defaultExtension: 'js'
    }
	}
});
console.error.bind(console, 'Message on Console !!! (System Start 0)');
System.import( baseUrl + '/apps/app02/boot')
      .then(null, console.error.bind(console));
