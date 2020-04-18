import { Component, OnInit, ViewContainerRef } from '@angular/core';
import { ColorPickerService, Cmyk } from 'ngx-color-picker';
import { CommonDataService } from './../../common-data.service';

@Component({
  selector: 'app-colorpicker',
  templateUrl: './colorpicker.component.html',
  styleUrls: ['./colorpicker.component.scss']
})
export class ColorpickerComponent implements OnInit {
public toggle: boolean = false;

public rgbaText: string = 'rgba(165, 26, 214, 0.2)';

public arrayColors: any = {
    color1: '#2883e9',
    color2: '#e920e9',
    color3: 'rgb(255,245,0)',
    color4: 'rgb(236,64,64)',
    color5: 'rgba(45,208,45,1)'
  };

  public selectedColor: string = 'color1';
  public selectedColor1: string = 'color2';

 public color1: string = '#2889e9';
  public color2: string = 'rgb(0, 255, 255)';
  public color3: string = '#fff500';
  public color4: string = '#a51ad633';//'rgb(236,64,64)';
  public color5: string = 'rgba(45,208,45,1)';
  public color6: string = '#f200bd';
  public color7: string = '#f200bd';
  public color8: string = 'rgba(0, 255, 0, 0.5)';
  public color9: string = '#278ce2';
  public color10: string = 'rgb(236,64,64)';
  public color11: string = '#f2ff00';
  public color12: string = '#f200bd';
  public color13: string = 'rgba(0, 255, 0, 0.5)';
  public color14: string = 'rgb(0, 255, 255)';
  public color15: string = '#a51ad633';
  public color16: string = 'rgba(45,208,45,0.5)';
  public color17: string = '#f200bd';
  public color18: string = '#fff500';

public cmykColor: Cmyk = new Cmyk(0, 0, 0, 0);

  constructor(private _commondata: CommonDataService, public vcRef: ViewContainerRef, private cpService: ColorPickerService) { }

  ngOnInit() {
  this._commondata.setExpandDiv('elements');
setTimeout(_ => this._commondata.showLoader(false), 200);
  }

  public onEventLog(event: string, data: any): void {
    console.log(event, data);
  }

  public onChangeColor(color: string): Cmyk {
    const hsva = this.cpService.stringToHsva(color);

    const rgba = this.cpService.hsvaToRgba(hsva);

    return this.cpService.rgbaToCmyk(rgba);
  }

  public onChangeColorHex8(color: string): string {
    const hsva = this.cpService.stringToHsva(color, true);

    return this.cpService.outputFormat(hsva, 'rgba', null);
  }

}
