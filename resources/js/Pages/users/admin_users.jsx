import {useEffect} from "react";
import "@src/css/home.css"
import Layout from "@src/js/components/Layout.jsx";
import {displayDate} from "@src/js/script/helpers.js"

export default function admin_users({usersJSON}) {
    const appURL = window.REACT_APP.APP_URL;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const users = usersJSON === undefined ? null : JSON.parse(usersJSON);

    useEffect(() => {
        document.title = "Users";

        const appDiv = document.getElementById('app');
        if (appDiv) {
            appDiv.removeAttribute('data-page');
        }
    }, []);

    return (
        <Layout>
            <div className="container py-4">
                <div className="row">
                    <div className="col-xl-12">
                        <h1>All Users</h1>
                        <p className="lead">
                            {(users.length === 1) ? (
                                "There is 1 user."
                            ) : (
                                "There are " + users.length + " users."
                            )}
                        </p>
                        {(users.length > 0) &&
                            <div className="table-responsive">
                                <table className="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col">First name</th>
                                            <th scope="col">Last name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Phone</th>
                                            <th scope="col">Language</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Privileges</th>
                                            <th scope="col">Created At</th>
                                            <th scope="col">Timezone</th>
                                            <th scope="col">Date of Birth</th>
                                            <th scope="col">Pronouns</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {users.map((user) => (
                                            <tr>
                                                <td>
                                                    <a href={appURL + "/edit-users?id=" + user.userId} className="btn btn-sm btn-outline-warning my-1">Edit</a>
                                                    <form action={appURL + "/users"} method="POST">
                                                        <input type="hidden" name="_token" value={csrfToken} />
                                                        <input type="hidden" name="id" id="id" value={user.userId}/>
                                                        <button type="submit" className="btn btn-sm btn-outline-danger">
                                                            {(user.status === "inactive") ? (
                                                                "Activate"
                                                            ) : (
                                                                "Deactivate"
                                                            )}
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>{user.firstName}</td>
                                                <td>{user.lastName}</td>
                                                <td><a href={appURL + "/view-profile?id=" + user.userId}>{user.email}</a></td>
                                                <td>{user.phone}</td>
                                                <td>{user.language}</td>
                                                <td>{user.status}</td>
                                                <td>{user.privileges}</td>
                                                <td>{displayDate(user.createdAt)}</td>
                                                <td>{user.timezone}</td>
                                                <td>{displayDate(user.dateofbirth)}</td>
                                                <td>{user.pronouns}</td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        }
                    </div>
                </div>
            </div>
        </Layout>
    );
}


