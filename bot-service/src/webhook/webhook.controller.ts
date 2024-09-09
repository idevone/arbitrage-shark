import { Body, Controller, Get, Post } from '@nestjs/common';
import { WebhookService } from './webhook.service';

@Controller('webhook')
export class WebhookController {
  constructor(private readonly webService: WebhookService) {}

  // @Get()
  // getHello1(): string {
  //   return this.webService.getHello();
  // }

  @Post()
  handleWebhook(@Body() data: any): string {
    console.log(data);
    return this.webService.getHello();
  }
}
