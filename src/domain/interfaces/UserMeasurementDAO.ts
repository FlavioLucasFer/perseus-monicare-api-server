import UserMeasurement from "../entities/UserMeasurement";

// Interface for the DAO of users measurements
interface UserMeasurementDAO {
	// Method to save new measurement for user 
	save(userId: number | string, userMeasurement: UserMeasurement) : Promise<number | string>;
	// Method to remove measurement from user
	remove(userId: number | string, userMeasurementId: number | string) : Promise<void>;
	// Method to find all measurements of user
	findAll(userId: number | string, where?: object) : Promise<Array<UserMeasurement>>;
	// Method to find mesurement of user by id
	findById(userId: number | string, userMeasurementId: number | string) : Promise<UserMeasurement>;
	// Method to find one mesurement of user
	findOne(userId: number | string, where: object) : Promise<UserMeasurement>;
}

export default UserMeasurementDAO;