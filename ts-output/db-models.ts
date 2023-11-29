import { Injectable } from '@angular/core';

@Injectable()
export class K1appUsersModel {
    user_login: string = null;
    user_level: string = null;
    user_names: string = null;
    user_last_names: string = null;
    user_phone_personal: string = null;
    user_password: string = null;
    user_datetime_in: string = null;

}
export class TableExampleModel {
    id: number = null;
    value: string = null;
    bolean: string = null;
    options: string = null;
    text: string = null;
    date: string = null;
    required: string = null;
    user_login: string = null;

}
export class TableUploadsModel {
    uid: number = null;
    id: number = null;
    user_login: string = null;
    file-name: string = null;
    01_colname: string = null;

}
