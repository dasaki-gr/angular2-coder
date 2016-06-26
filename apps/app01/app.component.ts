import {Component} from 'angular2/core';


@Component({
    selector: 'myapp',
    template: `<h1>Hello {{title}}</h1>
                <span>Clicks: {{count}}<span>
                <button (click)="increaseCount()">Click me</button>
                `
})
export class AppComponent {
        count = 0;
        title = "World. This is 1st example in Wordpress";
  increaseCount(){
		this.count++;
	}
}
