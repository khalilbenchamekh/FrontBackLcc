import * as types from "../../Constansts";
import callApi from "../../utils/call-api";



export function logout() {
  return (dispatch, getState) => {
    const { isFetching } = getState().services;

    if (isFetching.logout) {
      return Promise.resolve();
    }

    dispatch({
      type: types.LOGOUT_REQUEST,
    });

    return callApi('/logout')
      .then((json) => {
        // Remove JWT from localStorage
        localStorage.removeItem('token');

        // redirect to welcome in case of failure
        dispatch({
          type: types.LOGOUT_SUCCESS,
          payload: json,
        });
      })
      .catch(reason =>
        dispatch({
          type: types.LOGOUT_FAILURE,
          payload: reason,
        }));
  };
}

export function recieveAuth() {
  return (dispatch, getState) => {
    const { token } = getState().auth;

    dispatch({
      type: types.RECIEVE_AUTH_REQUEST,
    });

    return callApi('/users/me', token)
      .then(json =>
        dispatch({
          type: types.RECIEVE_AUTH_SUCCESS,
          payload: json,
        }))
      .catch(reason =>
        dispatch({
          type: types.RECIEVE_AUTH_FAILURE,
          payload: reason,
        }));
  };
}
