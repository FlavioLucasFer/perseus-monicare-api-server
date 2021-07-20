import UserMeasurement from "../entities/UserMeasurement";
import UserMeasurementDAO from "../../database/dao/UserMeasurementDAO";
import { errorLog, successLog } from "../../utils/log";

class UserMeasurementService {
	#userMeasurementDAO = new UserMeasurementDAO();
	
	async save(userId: number | string, userMeasurement: UserMeasurement): Promise<number | string> {
		try {
			const insertedId = await this.#userMeasurementDAO.save(userId, userMeasurement);

			successLog('[DATABASE] User mesurement successfully saved!');
			return insertedId;
		} catch (err) {
			errorLog('[DATABASE] Some error occurred when saving user measurement...');
			errorLog(`[DATABASE ERROR] ${err}`);

			throw new Error(err);
		}
	}

	async remove(userId: number | string, userMeasurementId: number | string): Promise<void> {
		try {
			await this.#userMeasurementDAO.remove(userId, userMeasurementId);

			successLog('[DATABASE] User measurement successfully removed!');
		} catch (err) {
			errorLog('[DATABASE] Some error occurred when removing user measurement...');
			errorLog(`[DATABASE ERROR] ${err}`);

			throw new Error(err);
		}
	}

	async findAll(userId: number | string, where?: object): Promise<Array<UserMeasurement>> {
		try {
			const userMeasurements = await this.#userMeasurementDAO.findAll(userId, where);

			successLog('[DATABASE] User measurements successfully queried!');
			return userMeasurements;
		} catch (err) {
			errorLog('[DATABASE] Some error occurred when querying for user measurements...');
			errorLog(`[DATABASE ERROR] ${err}`);

			throw new Error(err);
		}
	}

	async findById(userId: number | string, userMeasurementId: number | string): Promise<UserMeasurement> {
		try {
			const userMeasurement = await this.#userMeasurementDAO.findById(userId, userMeasurementId);
			
			successLog('[DATABASE] User measurement successfully queried!');
			return userMeasurement;
		} catch (err) {
			errorLog('[DATABASE] Some error occurred when querying for user measurement');
			errorLog(`[DATABASE ERROR] ${err}`);

			throw new Error(err);
		}
	}

	async findOne(userId: number | string, where: object): Promise<UserMeasurement> {
		try {
			const userMeasurement = await this.#userMeasurementDAO.findOne(userId, where);

			successLog('[DATABASE] User measurement successfully queried!');
			return userMeasurement;
		} catch (err) {
			errorLog('[DATABASE] Some error occurred when querying for user measurement');
			errorLog(`[DATABASE ERROR] ${err}`);

			throw new Error(err);
		}
	}
}

export default UserMeasurementService;
