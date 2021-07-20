class UserMeasurement {
	#id: number | string;
	#bodyTemperature: number;
	#bloodOxygenation: number;
	#heartRate: number;
	#measuredAt: Date;
	#createdAt: Date;

	constructor({
		id,
		bodyTemperature,
		bloodOxygenation,
		measuredAt,
		heartRate,
		createdAt,
	} : {
		id?: number | string,
		bodyTemperature: number,
		bloodOxygenation: number,
		heartRate: number,
		measuredAt: Date,
		createdAt?: Date,
	}) {
		this.#id = id;
		this.#bodyTemperature = bodyTemperature;
		this.#bloodOxygenation = bloodOxygenation;
		this.#heartRate = heartRate;
		this.#measuredAt = measuredAt;
		this.#createdAt = createdAt;
	}

	get id() {
		return this.#id;
	}

	get bodyTemperature() {
		return this.#bodyTemperature;
	}

	get bloodOxygenation() {
		return this.#bloodOxygenation;
	}

	get heartRate() {
		return this.#heartRate;
	}

	get measuredAt() {
		return this.#measuredAt;
	}

	get createdAt() {
		return this.#createdAt;
	}
}

export default UserMeasurement;