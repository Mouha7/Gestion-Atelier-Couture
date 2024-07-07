export class Model {

    async getData(url) {
        const response = await fetch(url);
        return await response.json();
    }

}

export const WEBROOT = "http://localhost:8000/";