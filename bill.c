#include <stdio.h>
#include <stdlib.h>
#include <string.h>

struct MenuItem {
    char name[50];
    float price;
};

struct MenuItem menu[] = {
    {"Biriyani", 120},
    {"Full Meals", 100},
    {"Mini Meal", 80},
    {"Parotta", 15},
    {"Soda", 15},
    {"Ice Cream", 50},
    {"Chicken Fry", 200},
    {"Fish Fry", 150},
    {"Paneer Butter Masala", 120},
    {"Paneer Tikka", 100}
};

int menuSize = sizeof(menu) / sizeof(menu[0]);

float find_price(const char *item_name) {
    for (int i = 0; i < menuSize; i++) {
        if (strcmp(menu[i].name, item_name) == 0) {
            return menu[i].price;
        }
    }
    return 0.0;
}

int main(int argc, char *argv[]) {
    if (argc < 2) {
        printf("Invalid input");
        return 1;
    }

    char input[1000];
    strcpy(input, argv[1]);

    // Parse the input: name|dob|item1:qty1,item2:qty2,...
    char *name = strtok(input, "|");
    char *dob = strtok(NULL, "|");
    char *items_str = strtok(NULL, "|");

    if (items_str == NULL) {
        printf("No items found.\n");
        return 1;
    }

    char *item_token = strtok(items_str, ",");
    while (item_token != NULL) {
        char item_name[100];
        int quantity;
        sscanf(item_token, "%[^:]:%d", item_name, &quantity);

        float unit_price = find_price(item_name);
        float total_price = unit_price * quantity;

        printf("%s x %d = %.2f\n", item_name, quantity, total_price);

        item_token = strtok(NULL, ",");
    }

    return 0;
}
