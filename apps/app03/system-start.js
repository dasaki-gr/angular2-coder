// from http://blog.thoughtram.io/angular/2016/01/06/taking-advantage-of-observables-in-angular2.html
System.config({
  // //use typescript for compilation
  // transpiler: 'typescript',
  // //typescript compiler options
  // typescriptOptions: {
  //   emitDecoratorMetadata: true
  // },
  //map tells the System loader where to look for things
  map: {
    app: baseUrl + '/apps/app03'
  },
  //packages defines our app package
  packages: {
    app: {
      main: baseUrl +'/apps/app03/boot.js',
      defaultExtension: 'js'
    }
  }
});
// System.config({
//   packages: {
//     [(baseUrl + '/apps/app03')]: {
//       format: 'register',
//       defaultExtension: 'js'
//     }
// 	}
// });
// console.error.bind(console, 'Message on Console !!! (System Start 0)');
System.import( baseUrl + '/apps/app03/boot')
      .then(null, console.error.bind(console));
