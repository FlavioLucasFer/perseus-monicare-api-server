import UserModel from '../mongodb/models/User';
import UserMeasurementDAOInterface from "../../domain/interfaces/UserMeasurementDAO";
import UserMeasurement from "../../domain/entities/UserMeasurement";

class UserMeasurementDAO implements UserMeasurementDAOInterface {
	// Saves new measurement to a user and returns inserted id
	async save(userId: number | string, userMeasurement: UserMeasurement) : Promise<number | string> {
		const {
			bodyTemperature,
			bloodOxygenation,
			heartRate,
			measuredAt,
		} = userMeasurement;

		const user = await UserModel.findByIdAndUpdate(userId, {
			$push: {
				'user_measurements': {
					bodyTemperature,
					bloodOxygenation,
					heartRate,
					measuredAt,
				},
			},
		});

		await user.save();

		const userMeasurements = await this.findAll(userId);
		return userMeasurements[userMeasurements.length - 1].id;
	}

	// Removes measurement of a user
	async remove(userId: number | string, userMeasurementId: number | string) : Promise<void> {
		await UserModel.findByIdAndUpdate(userId, {
			$pull: {'user_measurements': {_id: userMeasurementId}}
		});
	}

	// Finds all measurements from a user
	async findAll(userId: number | string, where?: object) : Promise<Array<UserMeasurement>> {
		return (await UserModel.findById(userId, where)).userMeasurements;
	}

	// Finds measurement of a user by id
	async findById(userId: number | string, userMeasurementId: number | string) : Promise<UserMeasurement> {
		const user = await UserModel.findById(userId);

		return user.userMeasurements.find(({ id }) => id === userMeasurementId);
	}

	// Finds one measurement of a user
	async findOne(userId: number | string, where?: object) : Promise<UserMeasurement> {
		return (await UserModel.findById(userId, where)).userMeasurements[0];
	}
} 

export default UserMeasurementDAO;