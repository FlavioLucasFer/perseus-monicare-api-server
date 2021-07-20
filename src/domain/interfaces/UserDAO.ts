import User from "../entities/User";

// Interface for the user's DAO
interface UserDAO {
	// Method to save new or edited user and return insertedId of saved new user
	save(user: User) : Promise<string | number | void>;
	// Method to remove user (inactivate actually)
	remove(id: number | string) : Promise<void>;
	// Method to find active users
	find(where?: object) : Promise<Array<User>>;
	// Method to find all users, inactive too
	findAll(where?: object) : Promise<Array<User>>;
	// Method to find user by id
	findById(id: number | string) : Promise<User>;
	// Method to find one user
	findOne(where: object) : Promise<User>;
}

export default UserDAO;