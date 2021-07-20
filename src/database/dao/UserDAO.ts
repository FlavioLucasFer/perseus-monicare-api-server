import UserModel from '../mongodb/models/User';
import UserDAOInterface from "../../domain/interfaces/UserDAO";
import User, { USER_STATUS } from "../../domain/entities/User";

class UserDAO implements UserDAOInterface {
	// Saves user, edited or new
	async save(user: User): Promise<number | string | void> {
		const {
			id,
			name,
			age,
			federalDocument,
			password,
			type,
		} = user;

		// If haven't id, saves new user and returns insertedId
		if (!id) {
			const newUser = await new UserModel({
				name,
				age,
				federalDocument,
				password,
			}).save();

			return newUser._id;
		} 

		// If have id, saves edited user
		await UserModel.findByIdAndUpdate(user.id, {			
			...(age) && {age},
			...(name) && {name},
			...(federalDocument) && {federalDocument},
			...(password) && {password},
			...(type) && {type},
		});
	}

	// Removes user (inactivates actually)
	async remove(id: number | string) : Promise<void> {
		await UserModel.findByIdAndUpdate(id, {			
			status: USER_STATUS.inactive,
		});
	}

	// Finds activated users
	async find(where?: object) : Promise<Array<User>> {
		return await UserModel.find({...where, status: USER_STATUS.active});
	}

	// Finds all users, inactivated users too
	async findAll(where?: object) : Promise<Array<User>> {
		return await UserModel.find(where);
	}

	// Finds one user
	async findOne(where: object) : Promise<User> {
		return await UserModel.findOne(where);
	}

	// Finds one user by id
	async findById(id: number | string) : Promise<User> {
		return await UserModel.findById(id);
	}
}

export default UserDAO;