import re

def extract_phone_number_with_multiple_expressions(text):
    phone = extract_phone_number_with_regular_expression_v1(text)

    if phone is None:
        phone = extract_phone_number_with_regular_expression_v2(text)

    if phone is None:
        phone = extract_phone_number_with_regular_expression_v3(text)

    if phone is None:
        phone = extract_phone_number_with_regular_expression_v4(text)

    return phone

def extract_phone_number_with_regular_expression_v1(text):
    phone = re.compile(
        r'''([(]?(\d{3})?[)]?(\s|-|\.)?(\d{3})(\s|-|\.)(\d{4})(\s|,)(\s*(ext|x|ext.)\s*(\d{2,5}))?)''', re.VERBOSE | re.IGNORECASE
    ).search(text)

    if phone:
        number = ''.join(phone[0])
        if len(number) > 10:
            return '+' + number
        else:
            return number


def extract_phone_number_with_regular_expression_v2(text):

    phone = re.findall(re.compile(
        r'(?:(?:\+?([1-9]|[0-9][0-9]|[0-9][0-9][0-9])\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([0-9][1-9]|[0-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?'
    ),text)

    if phone:
        number = ''.join(phone[0])
        if len(number) > 10:
            return '+' + number
        else:
            return number

def extract_phone_number_with_regular_expression_v3(text):

    phone = re.findall(re.compile(
        r'\+[-()\s\d]+?(?=\s*[+<])'
    ),text)

    if phone:
        number = ''.join(phone[0])
        if len(number) > 10:
            return '+' + number
        else:
            return number

def extract_phone_number_with_regular_expression_v4(text):

    phone = re.findall(re.compile(
        r'(\+91-)?(\+91)?([7-9]{1})([0-9]{9})'
    ),text)

    if phone:
        number = ''.join(phone[0])
        if len(number) > 10:
            return '+' + number
        else:
            return number

