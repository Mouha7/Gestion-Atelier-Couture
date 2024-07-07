import { Model, WEBROOT } from "../core/Model.js";

export class ApproModel extends Model {
    async getAllArticles() {
        const response = await this.getData(`${WEBROOT}?controller=rs&action=get-appro`);
        return response;
    }
}