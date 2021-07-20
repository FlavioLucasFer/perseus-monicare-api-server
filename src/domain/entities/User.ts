import UserMeasurement from "./UserMeasurement";

const USER_TYPES = {
	admin: 'A',
	doctor: 'D',
	patient: 'P',
	guardian: 'G',
};

const USER_STATUS = {
	active: 'A',
	inactive: 'I',
}

class User {
	#id: string | number;
	#name: string;
	#age: number;
	#federalDocument: string;
	#password: string;
	#type: string;
	#status: string;
	#userMeasurements: Array<UserMeasurement>;
	#createdAt: Date;
	#updatedAt: Date;

	constructor({
		id, 
		name, 
		age,
		federalDocument,
		password,
		type,
		status,
		userMeasurement,
		createdAt,
		updatedAt,
	} : {
		id?: string | number,
		name: string,
		age: number,
		federalDocument: string,
		password: string,
		type?: string,
		status?: string,
		userMeasurement?: Array<UserMeasurement>,
		createdAt?: Date,
		updatedAt?: Date,
	}) {
		this.#id = id;
		this.#name = name;
		this.#age = age;
		this.#federalDocument = federalDocument;
		this.#password = password;
		this.#type = type;
		this.#status = status;
		this.#userMeasurements = userMeasurement;
		this.#createdAt = createdAt;
		this.#updatedAt = updatedAt;
	}

	get id() : string | number {
		return this.#id;
	}

	get name() : string {
		return this.#name;
	}

	set name(name : string) {
		this.#name = name;
	}

	get age() : number {
		return this.#age;
	}

	set age(age: number) {
		this.#age = age;
	}

	get federalDocument() : string {
		return this.#federalDocument;
	}

	set federalDocument(federalDocument : string) {
		this.#federalDocument = federalDocument;
	}

	get password() : string {
		return this.#password;
	}

	set password(password: string) {
		this.#password = password;
	}

	get type() {
		return this.#type;
	}

	set type(type: string) {
		this.#type = type;
	}

	get status() {
		return this.#status;
	}

	set status(status: string) {
		this.#status = status;
	}

	get userMeasurements() {
		return this.#userMeasurements;
	}

	set userMeasurements(userMeasurements: Array<UserMeasurement>) {
		this.#userMeasurements = userMeasurements;
	}

	get createdAt() {
		return this.#createdAt;
	}

	get updatedAt() {
		return this.#updatedAt;
	}
};

export default User;
export {
	USER_TYPES,
	USER_STATUS,
};