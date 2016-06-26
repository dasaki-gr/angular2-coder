import {Component} from 'angular2/core';
import {Control} from 'angular2/common';
import {JSONP_PROVIDERS} from 'angular2/http';
import {WikipediaService} from './wikipedia-service'
import {Observable} from 'rxjs/Observable';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/debounceTime';
import 'rxjs/add/operator/distinctUntilChanged';
import 'rxjs/add/operator/switchMap';

@Component({
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
    providers:[WikipediaService, JSONP_PROVIDERS]
})
export class AppComponent {
    items: Observable<Array<string>>;
    term = new Control();
    constructor(private wikipediaService: WikipediaService) {
      this.items = this.term.valueChanges
                   .debounceTime(400)
                   .distinctUntilChanged()
                   .switchMap(term => this.wikipediaService.search(term));
    }
}
