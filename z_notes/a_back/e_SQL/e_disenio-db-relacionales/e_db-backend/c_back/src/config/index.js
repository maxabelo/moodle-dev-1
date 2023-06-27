import { config } from 'dotenv';

if (process.env.NODE_ENV !== 'producction') config();

export const PORT = process.env.PORT;

export const DB_NAME = process.env.DB_NAME;
export const DB_HOST = process.env.DB_HOST;
export const DB_USER = process.env.DB_USER;
export const DB_PASSWORD = process.env.DB_PASSWORD;
export const DB_PORT = process.env.DB_PORT;
export const DB_DIALECT = process.env.DB_DIALECT;

export const BACKEND_URL = process.env.BACKEND_URL;
export const SECRETORKEY_JWT = process.env.SECRETORKEY_JWT;

export const utils = { house_id: 1, department_id: 2 };
