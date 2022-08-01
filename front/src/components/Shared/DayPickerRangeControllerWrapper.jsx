import React from "react";
import PropTypes from "prop-types";
import momentPropTypes from "react-moment-proptypes";
import omit from "lodash/omit";
import moment from "moment";
import frLocale from "moment/locale/fr";

import {
  START_DATE,
  END_DATE,
  HORIZONTAL_ORIENTATION,
} from "react-dates/src/constants";
import isInclusivelyAfterDay from "react-dates/src/utils/isInclusivelyAfterDay";
import isAfterDay from "react-dates/src/utils/isAfterDay";
import {
  DayPickerRangeController,
  ScrollableOrientationShape,
} from "react-dates";
import { forbidExtraProps } from "airbnb-prop-types/src/mocks";
import { connect } from "react-redux";

const propTypes = forbidExtraProps({
  // example props for the demo
  autoFocusEndDate: PropTypes.bool,
  initialStartDate: momentPropTypes.momentObj,
  initialEndDate: momentPropTypes.momentObj,
  startDateOffset: PropTypes.func,
  endDateOffset: PropTypes.func,
  showInputs: PropTypes.bool,
  minDate: momentPropTypes.momentObj,
  maxDate: momentPropTypes.momentObj,

  keepOpenOnDateSelect: PropTypes.bool,
  minimumNights: PropTypes.number,
  isOutsideRange: PropTypes.func,
  isDayBlocked: PropTypes.func,
  isDayHighlighted: PropTypes.func,

  // DayPicker props
  enableOutsideDays: PropTypes.bool,
  numberOfMonths: PropTypes.number,
  orientation: ScrollableOrientationShape,
  verticalHeight: PropTypes.number,
  withPortal: PropTypes.bool,
  initialVisibleMonth: PropTypes.func,
  renderCalendarInfo: PropTypes.func,
  renderMonthElement: PropTypes.func,
  renderMonthText: PropTypes.func,

  navPrev: PropTypes.node,
  navNext: PropTypes.node,

  onPrevMonthClick: PropTypes.func,
  onNextMonthClick: PropTypes.func,
  onOutsideClick: PropTypes.func,
  renderCalendarDay: PropTypes.func,
  renderDayContents: PropTypes.func,
  renderKeyboardShortcutsButton: PropTypes.func,

  // i18n
  monthFormat: PropTypes.string,

  isRTL: PropTypes.bool,
});

const defaultProps = {
  // example props for the demo
  autoFocusEndDate: false,
  initialStartDate: null,
  initialEndDate: null,
  startDateOffset: undefined,
  endDateOffset: undefined,
  showInputs: false,
  minDate: null,
  maxDate: null,

  // day presentation and interaction related props
  renderCalendarDay: undefined,
  renderDayContents: null,
  minimumNights: 1,
  isDayBlocked: () => false,
  isOutsideRange: (day) => isAfterDay(day, moment()),
  isDayHighlighted: () => false,
  enableOutsideDays: false,

  // calendar presentation and interaction related props
  orientation: HORIZONTAL_ORIENTATION,
  verticalHeight: undefined,
  withPortal: false,
  initialVisibleMonth: null,
  numberOfMonths: 2,
  onOutsideClick() {},
  keepOpenOnDateSelect: false,
  renderCalendarInfo: null,
  isRTL: false,
  renderMonthText: null,
  renderMonthElement: null,
  renderKeyboardShortcutsButton: undefined,

  // navigation related props
  navPrev: null,
  navNext: null,
  onPrevMonthClick() {},
  onNextMonthClick() {},

  // internationalization
  monthFormat: "MMMM YYYY",
};

class DayPickerRangeControllerWrapper extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      focusedInput: props.autoFocusEndDate ? END_DATE : START_DATE,
      startDate: props.initialStartDate,
      endDate: props.initialEndDate,
    };

    this.onDatesChange = this.onDatesChange.bind(this);
    this.onFocusChange = this.onFocusChange.bind(this);
  }

  onDatesChange({ startDate, endDate }) {
    let checkStart = moment(startDate, "YYYY/MM/DD");

    let monthStart = checkStart.format("MMMM");
    let dayStart = checkStart.format("D");

    let checkEnd = moment(endDate, "YYYY/MM/DD");

    let monthEnd = checkEnd.format("MMMM");
    let dayEnd = checkEnd.format("D");

    let date;
    if (endDate === null) {
      date = {
        first: dayStart + " " + monthStart,
        second: "Départ",
        firstIso: moment(startDate).toISOString(),
        secondIso: moment(endDate).toISOString(),
      };
      this.props.dispatch({
        type: "Add_Date",
        date: date,
      });
    } else {
      date = {
        first: dayStart + " " + monthStart,
        second: dayEnd + " " + monthEnd,
        firstIso: moment(startDate).toISOString(),
        secondIso: moment(endDate).toISOString(),
      };
      this.props.dispatch({
        type: "Add_Date",
        date: date,
      });
    }

    this.setState({ startDate, endDate });
  }

  onFocusChange(focusedInput) {
    this.setState({
      // Force the focusedInput to always be truthy so that dates are always selectable
      focusedInput: !focusedInput ? START_DATE : focusedInput,
    });
  }

  render() {
    const { showInputs, date, show } = this.props;
    const { focusedInput, startDate, endDate } = this.state;

    const props = omit(this.props, [
      "autoFocus",
      "autoFocusEndDate",
      "initialStartDate",
      "initialEndDate",
      "showInputs",
    ]);

    const startDateString = startDate && startDate.format("YYYY-MM-DD");
    const endDateString = endDate && endDate.format("YYYY-MM-DD");
    moment.locale("fr", frLocale);
    if (!show) return <></>;
    return (
      <div style={{ height: "100%" }}>
        {showInputs && (
          <div style={{ marginBottom: 16 }}>
            <input
              type="text"
              name="start date"
              value={startDateString}
              readOnly
            />
            <input type="text" name="end date" value={endDateString} readOnly />
          </div>
        )}
        <DayPickerRangeController
          {...props}
          onDatesChange={this.onDatesChange}
          onFocusChange={this.onFocusChange}
          focusedInput={focusedInput}
          startDate={
            date.date !== undefined
              ? date.date.firstIso === ""
                ? startDate
                : moment(date.date.firstIso)
              : startDate
          }
          endDate={
            date.date !== undefined
              ? date.date.secondIso === ""
                ? endDate
                : moment(date.date.secondIso)
              : endDate
          }
          hideKeyboardShortcutsPanel={true}
        />
      </div>
    );
  }
}

DayPickerRangeControllerWrapper.propTypes = propTypes;
DayPickerRangeControllerWrapper.defaultProps = defaultProps;

function mapStateToProps(state) {
  return {
    date: state.DatefilterReducer.date,
  };
}

export default connect(mapStateToProps)(DayPickerRangeControllerWrapper);
