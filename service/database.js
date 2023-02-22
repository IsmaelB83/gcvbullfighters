// Node imports
const mysql = require('mysql2/promise');

class Database {
    
    // Constructor - create connection
    constructor() {
        this.config = {
            host: process.env.DB_HOST,
            user: process.env.DB_USER,
            password: process.env.DB_PASSWORD,
            database: process.env.DB_DATABASE
        };
        this.connection = null;
    }
    
    // Connect
    async connect() {
        if (!this.connection) {
            try {
                this.connection = await mysql.createConnection(this.config);
            } catch (err) {
                throw err;
            }
        }
    }
    
    // Execute SQL statement
    async query(sql, args) {
        await this.connect();
        const [rows] = await this.connection.execute(sql, args);
        return rows;
    }
    
    // Close connection
    async close() {
        if (this.connection) {
            await this.connection.end();
            this.connection = null;
        }
    }
}

module.exports = Database;