import {Component} from 'angular2/core';

@Component({
    selector: 'myapp',
    template: `<h1>Hello {{title}}</h1>
                <span>Clicks: {{count}}<span>
                <button (click)="increaseCount()">Secont Press Button</button>
                `
})
export class AppComponent {
        count = 0;
        title = "This is a second Example";
  increaseCount(){
		this.count++;
	}
}
