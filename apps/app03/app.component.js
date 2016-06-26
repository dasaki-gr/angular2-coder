System.register(['angular2/core', 'angular2/common', 'angular2/http', './wikipedia-service', 'rxjs/add/operator/map', 'rxjs/add/operator/debounceTime', 'rxjs/add/operator/distinctUntilChanged', 'rxjs/add/operator/switchMap'], function(exports_1, context_1) {
    "use strict";
    var __moduleName = context_1 && context_1.id;
    var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
        var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
        if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
        else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
        return c > 3 && r && Object.defineProperty(target, key, r), r;
    };
    var __metadata = (this && this.__metadata) || function (k, v) {
        if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
    };
    var core_1, common_1, http_1, wikipedia_service_1;
    var AppComponent;
    return {
        setters:[
            function (core_1_1) {
                core_1 = core_1_1;
            },
            function (common_1_1) {
                common_1 = common_1_1;
            },
            function (http_1_1) {
                http_1 = http_1_1;
            },
            function (wikipedia_service_1_1) {
                wikipedia_service_1 = wikipedia_service_1_1;
            },
            function (_1) {},
            function (_2) {},
            function (_3) {},
            function (_4) {}],
        execute: function() {
            let AppComponent = class AppComponent {
                constructor(wikipediaService) {
                    this.wikipediaService = wikipediaService;
                    this.term = new common_1.Control();
                    this.items = this.term.valueChanges
                        .debounceTime(400)
                        .distinctUntilChanged()
                        .switchMap(term => this.wikipediaService.search(term));
                }
            };
            AppComponent = __decorate([
                core_1.Component({
                    selector: 'myapp',
                    template: `
                <div>
                  Demonstrate an Example from <a href="http://plnkr.co/edit/m1m0P5Vbb4fIPmrDeOV8?p=info" target="_blank">Plunker</a>
                  <br>
                  Thanks to an article for <a href="http://blog.thoughtram.io/angular/2016/01/06/taking-advantage-of-observables-in-angular2.html" target="_blank">OBSERVABLES IN ANGULAR 2</a>
                  <br>
                </div>
                <div>
                  <h2>Wikipedia Search</h2>
                  <input type="text" [ngFormControl]="term"/>
                  <ul>
                    <li *ngFor="#item of items | async">{{item}}</li>
                  </ul>
                </div>
              `,
                    providers: [wikipedia_service_1.WikipediaService, http_1.JSONP_PROVIDERS]
                }), 
                __metadata('design:paramtypes', [wikipedia_service_1.WikipediaService])
            ], AppComponent);
            exports_1("AppComponent", AppComponent);
        }
    }
});
