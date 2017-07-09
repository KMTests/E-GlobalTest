class Config {
    constructor() {
        this.api_base = 'http://localhost:8086';
        this.api_client_id = '1_thisisnotsorandomid';
        this.api_client_secret = 'thisisnotsorandompassword';
    }
}

const config = new Config();
export default config;